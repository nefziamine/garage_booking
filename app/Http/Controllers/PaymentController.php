<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\GarageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function selectPaymentMethod(Booking $booking)
    {
        // Check if user owns the booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à payer cette réservation.');
        }

        // Check if booking is pending and payment is pending
        if ($booking->status !== 'pending' || $booking->payment_status !== 'pending') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Cette réservation n\'est pas éligible au paiement.');
        }

        return view('payments.method', compact('booking'));
    }

    public function createPaymentIntent(Booking $booking)
    {
        // Check if user owns the booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à payer cette réservation.');
        }

        // Check if booking is pending and payment is pending
        if ($booking->status !== 'pending' || $booking->payment_status !== 'pending') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Cette réservation n\'est pas éligible au paiement.');
        }

        $paymentMethod = request('payment_method');

        // If no payment method is specified, redirect to payment method selection
        if (!$paymentMethod) {
            return redirect()->route('payments.method', $booking)
                ->with('info', 'Veuillez sélectionner votre méthode de paiement.');
        }

        try {
            // Verify booking can be paid
            if ($booking->status !== 'pending' || $booking->payment_status !== 'pending') {
                return redirect()->route('bookings.show', $booking)
                    ->with('error', 'Cette réservation ne peut plus être payée.');
            }

            // Get recommended additional services
            $recommendedServices = $this->getRecommendedServices($booking);

            if ($paymentMethod === 'd17') {
                // D17 payment - create payment via API
                try {
                    $d17Payment = $this->createD17Payment($booking, $booking->total_price);

                    if ($d17Payment && isset($d17Payment['redirect_url'])) {
                        // Redirect to D17 payment page
                        return redirect($d17Payment['redirect_url']);
                    } else {
                        throw new \Exception('Impossible de créer le paiement D17');
                    }
                } catch (\Exception $e) {
                    return redirect()->route('bookings.show', $booking)
                        ->with('error', 'Erreur D17: ' . $e->getMessage());
                }
            }

            // Check if we're in test mode (no Stripe keys configured or invalid key)
            $stripeKey = config('services.stripe.secret');
            $isTestMode = empty($stripeKey) ||
                          $stripeKey === 'your_stripe_secret_key_here' ||
                          str_contains($stripeKey, 'your_stripe') ||
                          str_contains($stripeKey, '****************');

            if ($isTestMode) {
                // Test mode - simulate payment intent
                $paymentIntent = (object) [
                    'id' => 'test_pi_' . $booking->id . '_' . time(),
                    'client_secret' => 'test_secret_' . $booking->id,
                    'amount' => $booking->total_price * 100,
                    'currency' => 'tnd',
                ];

                return view('payments.checkout', compact('booking', 'paymentIntent', 'recommendedServices', 'paymentMethod'))
                    ->with('test_mode', true);
            }

            $paymentIntent = PaymentIntent::create([
                'amount' => $booking->total_price * 100, // Stripe expects amount in cents
                'currency' => 'tnd', // Tunisian Dinar
                'metadata' => [
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                ],
            ]);

            return view('payments.checkout', compact('booking', 'paymentIntent', 'recommendedServices', 'paymentMethod'));
        } catch (ApiErrorException $e) {
            // Stripe-specific error
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Erreur de paiement Stripe: ' . $e->getMessage());
        } catch (\Exception $e) {
            // General error
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Erreur lors de la création du paiement: ' . $e->getMessage());
        }
    }

    public function processPayment(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
            'additional_services' => 'nullable|array',
            'additional_services.*' => 'exists:garage_services,id',
        ]);

        // Check if user owns the booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à payer cette réservation.');
        }

        try {
            // Calculate total amount including additional services
            $totalAmount = $booking->total_price;
            $additionalBookings = [];

            if ($request->has('additional_services') && is_array($request->additional_services)) {
                foreach ($request->additional_services as $serviceId) {
                    $service = GarageService::findOrFail($serviceId);

                    // Ensure the service belongs to the same garage
                    if ($service->garage_id !== $booking->garage_id) {
                        throw new \Exception('Service supplémentaire invalide.');
                    }

                    $totalAmount += $service->price;

                    // Create additional booking
                    $additionalBooking = Booking::create([
                        'user_id' => $booking->user_id,
                        'garage_id' => $booking->garage_id,
                        'service_id' => $service->id,
                        'booking_date' => $booking->booking_date,
                        'booking_time' => $booking->booking_time,
                        'status' => 'pending',
                        'notes' => 'Service complémentaire ajouté lors du paiement',
                        'total_price' => $service->price,
                        'vehicle_info' => $booking->vehicle_info,
                        'estimated_duration' => $service->duration,
                        'payment_status' => 'pending',
                    ]);

                    $additionalBookings[] = $additionalBooking;
                }
            }

            // Check payment method from payment intent ID or direct D17 data
            $isD17Payment = str_starts_with($request->payment_intent_id, 'd17_') ||
                           $request->has('d17_card_number');
            $isTestPayment = str_starts_with($request->payment_intent_id, 'test_');

            if ($isD17Payment) {
                // D17 payment - validate card data and simulate successful payment
                $request->validate([
                    'd17_phone' => 'required|string',
                    'd17_card_number' => 'required|string',
                    'd17_cvc' => 'required|string',
                    'd17_expiry' => 'required|string',
                ]);

                // Here you would normally send the card data to D17 API
                // For now, we'll simulate a successful payment

                // Update main booking payment status and confirm booking
                $booking->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'payment_method' => 'd17',
                    'payment_id' => 'd17_' . time() . '_' . $booking->id,
                    'paid_amount' => $totalAmount,
                    'paid_at' => now(),
                ]);

                // Update additional bookings
                foreach ($additionalBookings as $additionalBooking) {
                    $additionalBooking->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_method' => 'd17',
                        'payment_id' => 'd17_' . time() . '_' . $additionalBooking->id,
                        'paid_amount' => $additionalBooking->total_price,
                        'paid_at' => now(),
                    ]);
                }

                return redirect()->route('payments.success', $booking)
                    ->with('success', 'Paiement D17 effectué avec succès ! Toutes les réservations sont confirmées.');
            }

            // Check if we're in test mode
            $stripeKey = config('services.stripe.secret');
            $isTestMode = empty($stripeKey) ||
                          $stripeKey === 'your_stripe_secret_key_here' ||
                          str_contains($stripeKey, 'your_stripe') ||
                          str_contains($stripeKey, '****************');

            if ($isTestMode || $isTestPayment) {
                // Test mode - simulate successful payment
                // Update main booking payment status and confirm booking
                $booking->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'payment_method' => 'test',
                    'payment_id' => 'test_' . $request->payment_intent_id,
                    'paid_amount' => $totalAmount,
                    'paid_at' => now(),
                ]);

                // Update additional bookings
                foreach ($additionalBookings as $additionalBooking) {
                    $additionalBooking->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_method' => 'test',
                        'payment_id' => 'test_' . $request->payment_intent_id,
                        'paid_amount' => $additionalBooking->total_price,
                        'paid_at' => now(),
                    ]);
                }

                return redirect()->route('payments.success', $booking)
                    ->with('success', 'Paiement de test effectué avec succès ! Toutes les réservations sont confirmées.');
            }

            // Production mode with Stripe
            // Update the payment intent with the new amount
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            // If amount changed, update the payment intent
            if ($paymentIntent->amount !== $totalAmount * 100) {
                $paymentIntent = PaymentIntent::update($paymentIntent->id, [
                    'amount' => $totalAmount * 100,
                ]);
            }

            $paymentIntent->confirm([
                'payment_method' => $request->payment_method_id,
            ]);

            if ($paymentIntent->status === 'succeeded') {
                // Update main booking payment status and confirm booking
                $booking->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'payment_method' => 'stripe',
                    'payment_id' => $paymentIntent->id,
                    'paid_amount' => $totalAmount,
                    'paid_at' => now(),
                ]);

                // Update additional bookings
                foreach ($additionalBookings as $additionalBooking) {
                    $additionalBooking->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_method' => 'stripe',
                        'payment_id' => $paymentIntent->id,
                        'paid_amount' => $additionalBooking->total_price,
                        'paid_at' => now(),
                    ]);
                }

                return redirect()->route('payments.success', $booking)
                    ->with('success', 'Paiement effectué avec succès ! Toutes les réservations sont confirmées.');
            } else {
                // If payment failed, delete additional bookings
                foreach ($additionalBookings as $additionalBooking) {
                    $additionalBooking->delete();
                }

                return redirect()->route('payments.checkout', $booking)
                    ->with('error', 'Le paiement a échoué. Veuillez réessayer.');
            }
        } catch (\Exception $e) {
            // If there was an error, delete any additional bookings that were created
            if (isset($additionalBookings)) {
                foreach ($additionalBookings as $additionalBooking) {
                    $additionalBooking->delete();
                }
            }

            return redirect()->route('payments.checkout', $booking)
                ->with('error', 'Erreur lors du traitement du paiement: ' . $e->getMessage());
        }
    }

    public function success(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.success', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.cancel', compact('booking'));
    }

    /**
     * Get recommended additional services for the client
     */
    public function getRecommendedServices(Booking $booking)
    {
        $recommendedServices = collect();
        $garage = $booking->garage;
        $vehicleInfo = $booking->vehicle_info;
        $currentService = $booking->service;

        // Get all available services from the garage
        $allServices = GarageService::where('garage_id', $garage->id)
            ->where('is_available', true)
            ->where('id', '!=', $currentService->id)
            ->get();

        // If no services in GarageService table, try to get from garage's services array
        if ($allServices->isEmpty() && is_array($garage->services) && !empty($garage->services)) {
            $allServices = collect($garage->services)->map(function ($serviceName, $index) use ($garage) {
                return (object) [
                    'id' => 'temp_' . $index,
                    'name' => $serviceName,
                    'price' => rand(50, 300),
                    'duration' => rand(30, 240),
                    'is_available' => true,
                    'garage_id' => $garage->id,
                ];
            });
        }

        // If still no services, return empty
        if ($allServices->isEmpty()) {
            return $recommendedServices;
        }

        // 1. Recommendations based on vehicle age
        if (isset($vehicleInfo['year'])) {
            $vehicleAge = date('Y') - intval($vehicleInfo['year']);

            if ($vehicleAge >= 3) { // Lower threshold for more recommendations
                // Older vehicles might need maintenance services
                $maintenanceServices = $allServices->filter(function ($service) {
                    $name = strtolower($service->name ?? '');
                    return str_contains($name, 'vidange') ||
                           str_contains($name, 'entretien') ||
                           str_contains($name, 'révision') ||
                           str_contains($name, 'diagnostic') ||
                           str_contains($name, 'maintenance');
                });

                if ($maintenanceServices->isNotEmpty()) {
                    $recommendedServices = $recommendedServices->merge($maintenanceServices->take(2));
                }
            }
        }

        // 2. Recommendations based on current service type
        $currentServiceName = strtolower($currentService->name ?? '');

        if (str_contains($currentServiceName, 'réparation') || str_contains($currentServiceName, 'repair')) {
            // If repairing, suggest diagnostic or maintenance
            $relatedServices = $allServices->filter(function ($service) {
                $name = strtolower($service->name ?? '');
                return str_contains($name, 'diagnostic') ||
                       str_contains($name, 'contrôle') ||
                       str_contains($name, 'entretien') ||
                       str_contains($name, 'check');
            });
            if ($relatedServices->isNotEmpty()) {
                $recommendedServices = $recommendedServices->merge($relatedServices->take(1));
            }
        } elseif (str_contains($currentServiceName, 'vidange') || str_contains($currentServiceName, 'oil')) {
            // If oil change, suggest filter replacement or brake check
            $relatedServices = $allServices->filter(function ($service) {
                $name = strtolower($service->name ?? '');
                return str_contains($name, 'filtre') ||
                       str_contains($name, 'filter') ||
                       str_contains($name, 'frein') ||
                       str_contains($name, 'brake') ||
                       str_contains($name, 'batterie') ||
                       str_contains($name, 'battery');
            });
            if ($relatedServices->isNotEmpty()) {
                $recommendedServices = $recommendedServices->merge($relatedServices->take(1));
            }
        }

        // 3. Recommendations based on vehicle brand (common issues)
        if (isset($vehicleInfo['brand'])) {
            $brand = strtolower($vehicleInfo['brand']);

            if (str_contains($brand, 'renault') || str_contains($brand, 'peugeot') ||
                str_contains($brand, 'citroen') || str_contains($brand, 'fiat')) {
                // French/Italian brands often need timing belt services
                $brandServices = $allServices->filter(function ($service) {
                    $name = strtolower($service->name ?? '');
                    return str_contains($name, 'courroie') ||
                           str_contains($name, 'distribution') ||
                           str_contains($name, 'timing') ||
                           str_contains($name, 'belt');
                });
                if ($brandServices->isNotEmpty()) {
                    $recommendedServices = $recommendedServices->merge($brandServices->take(1));
                }
            }
        }

        // 4. General recommendations if we don't have enough
        if ($recommendedServices->count() < 2) {
            // Add any available services that aren't the current one
            $generalServices = $allServices->filter(function ($service) use ($recommendedServices) {
                return !$recommendedServices->contains('id', $service->id);
            })->take(3 - $recommendedServices->count());

            $recommendedServices = $recommendedServices->merge($generalServices);
        }

        // Remove duplicates and limit to 3 recommendations
        return $recommendedServices->unique('id')->take(3);
    }

    /**
     * Create payment modal content for booking creation
     */
    public function createPaymentModal(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'garage_id' => 'required|exists:garages,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'vehicle_info' => 'required|array',
            'vehicle_info.brand' => 'required|string',
            'vehicle_info.model' => 'required|string',
            'vehicle_info.year' => 'required|integer',
            'notes' => 'nullable|string'
        ]);

        try {
            // Get the garage and service
            $garage = Garage::findOrFail($request->garage_id);

            // Handle both real GarageService and temporary services
            if (str_starts_with($request->service_id, 'temp_')) {
                $serviceIndex = str_replace('temp_', '', $request->service_id);
                $serviceName = $garage->services[$serviceIndex] ?? 'Service';

                $service = (object) [
                    'id' => $request->service_id,
                    'name' => $serviceName,
                    'price' => rand(50, 300),
                    'duration' => rand(30, 240),
                    'description' => 'Service ajouté automatiquement'
                ];
            } else {
                $service = GarageService::findOrFail($request->service_id);
            }

            // Create temporary booking for recommendations
            $tempBooking = new Booking([
                'user_id' => auth()->id(),
                'garage_id' => $garage->id,
                'service_id' => is_object($service) && isset($service->id) ? $service->id : $request->service_id,
                'booking_date' => $request->booking_date,
                'booking_time' => $request->booking_time,
                'vehicle_info' => $request->vehicle_info,
                'notes' => $request->notes,
                'total_price' => $service->price,
                'status' => 'pending',
                'payment_status' => 'pending'
            ]);

            // Get recommended services
            $recommendedServices = $this->getRecommendedServices($tempBooking);

            // Check if Stripe is configured
            $stripeKey = config('services.stripe.secret');
            $isTestMode = empty($stripeKey) || $stripeKey === 'your_stripe_secret_key_here';

            return view('payments.modal-content', compact(
                'garage',
                'service',
                'tempBooking',
                'recommendedServices',
                'request',
                'isTestMode'
            ))->render();

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors du chargement du paiement: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create multi-payment checkout for multiple bookings
     */
    public function createMultiPaymentIntent()
    {
        $bookingIds = session('multi_payment_bookings', []);

        if (empty($bookingIds)) {
            return redirect()->route('welcome')->with('error', 'Aucune réservation trouvée pour le paiement.');
        }

        $bookings = Booking::whereIn('id', $bookingIds)
            ->where('user_id', auth()->id())
            ->with(['service', 'garage'])
            ->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('welcome')->with('error', 'Réservations introuvables.');
        }

        // Check if all bookings are pending payment
        foreach ($bookings as $booking) {
            if ($booking->status !== 'pending' || $booking->payment_status !== 'pending') {
                return redirect()->route('bookings.index')
                    ->with('error', 'Certaines réservations ne sont plus éligibles au paiement.');
            }
        }

        $totalAmount = $bookings->sum('total_price');

        // For now, default to Stripe for multi-payments
        $paymentMethod = 'stripe';

        try {
            // Check if we're in test mode
            $stripeKey = config('services.stripe.secret');
            $isTestMode = empty($stripeKey) ||
                          $stripeKey === 'your_stripe_secret_key_here' ||
                          str_contains($stripeKey, 'your_stripe') ||
                          str_contains($stripeKey, '****************');

            if ($isTestMode) {
                // Test mode
                $paymentIntent = (object) [
                    'id' => 'test_multi_pi_' . implode('_', $bookingIds) . '_' . time(),
                    'client_secret' => 'test_multi_secret_' . implode('_', $bookingIds),
                    'amount' => $totalAmount * 100,
                    'currency' => 'tnd',
                ];

                return view('payments.multi-checkout', compact('bookings', 'paymentIntent', 'totalAmount', 'paymentMethod'))
                    ->with('test_mode', true);
            }

            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100,
                'currency' => 'tnd',
                'metadata' => [
                    'booking_ids' => implode(',', $bookingIds),
                    'user_id' => auth()->id(),
                    'type' => 'multi_booking',
                ],
            ]);

            return view('payments.multi-checkout', compact('bookings', 'paymentIntent', 'totalAmount', 'paymentMethod'));
        } catch (\Exception $e) {
            return redirect()->route('bookings.index')
                ->with('error', 'Erreur lors de la création du paiement: ' . $e->getMessage());
        }
    }

    /**
     * Process multi-payment for multiple bookings
     */
    public function processMultiPayment(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
        ]);

        $bookingIds = session('multi_payment_bookings', []);

        if (empty($bookingIds)) {
            return redirect()->route('welcome')->with('error', 'Aucune réservation trouvée pour le paiement.');
        }

        $bookings = Booking::whereIn('id', $bookingIds)
            ->where('user_id', auth()->id())
            ->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('welcome')->with('error', 'Réservations introuvables.');
        }

        $totalAmount = $bookings->sum('total_price');

        try {
            // Check payment method from payment intent ID
            $isTestPayment = str_starts_with($request->payment_intent_id, 'test_');

            // Check if we're in test mode
            $stripeKey = config('services.stripe.secret');
            $isTestMode = empty($stripeKey) ||
                          $stripeKey === 'your_stripe_secret_key_here' ||
                          str_contains($stripeKey, 'your_stripe') ||
                          str_contains($stripeKey, '****************');

            if ($isTestMode || $isTestPayment) {
                // Test mode - simulate successful payment
                foreach ($bookings as $booking) {
                    $booking->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_method' => 'test',
                        'payment_id' => 'test_multi_' . $request->payment_intent_id,
                        'paid_amount' => $booking->total_price,
                        'paid_at' => now(),
                    ]);
                }

                // Clear session
                session()->forget('multi_payment_bookings');

                return redirect()->route('payments.multi_success')
                    ->with('success', 'Paiement de test effectué avec succès ! Toutes les réservations sont confirmées.');
            }

            // Production mode with Stripe
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            // If amount changed, update the payment intent
            if ($paymentIntent->amount !== $totalAmount * 100) {
                $paymentIntent = PaymentIntent::update($paymentIntent->id, [
                    'amount' => $totalAmount * 100,
                ]);
            }

            $paymentIntent->confirm([
                'payment_method' => $request->payment_method_id,
            ]);

            if ($paymentIntent->status === 'succeeded') {
                // Update all bookings
                foreach ($bookings as $booking) {
                    $booking->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_method' => 'stripe',
                        'payment_id' => $paymentIntent->id,
                        'paid_amount' => $booking->total_price,
                        'paid_at' => now(),
                    ]);
                }

                // Clear session
                session()->forget('multi_payment_bookings');

                return redirect()->route('payments.multi_success')
                    ->with('success', 'Paiement effectué avec succès ! Toutes les réservations sont confirmées.');
            } else {
                return redirect()->route('payments.multi_checkout')
                    ->with('error', 'Le paiement a échoué. Veuillez réessayer.');
            }
        } catch (\Exception $e) {
            // Clear session on error
            session()->forget('multi_payment_bookings');

            return redirect()->route('bookings.index')
                ->with('error', 'Erreur lors du traitement du paiement: ' . $e->getMessage());
        }
    }

    /**
     * Multi-payment success page
     */
    public function multiSuccess()
    {
        return view('payments.multi-success');
    }

    /**
     * Process D17 payment
     */
    private function processD17Payment(Booking $booking, array $additionalBookings, float $totalAmount)
    {
        // Update main booking payment status and confirm booking
        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'payment_method' => 'd17',
            'payment_id' => 'd17_' . time() . '_' . $booking->id,
            'paid_amount' => $totalAmount,
            'paid_at' => now(),
        ]);

        // Update additional bookings
        foreach ($additionalBookings as $additionalBooking) {
            $additionalBooking->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_method' => 'd17',
                'payment_id' => 'd17_' . time() . '_' . $additionalBooking->id,
                'paid_amount' => $additionalBooking->total_price,
                'paid_at' => now(),
            ]);
        }

        return redirect()->route('payments.success', $booking)
            ->with('success', 'Paiement D17 effectué avec succès ! Toutes les réservations sont confirmées.');
    }

    /**
     * Process test payment
     */
    private function processTestPayment(Booking $booking, array $additionalBookings, float $totalAmount, string $paymentIntentId)
    {
        // Update main booking payment status and confirm booking
        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'payment_method' => 'test',
            'payment_id' => 'test_' . $paymentIntentId,
            'paid_amount' => $totalAmount,
            'paid_at' => now(),
        ]);

        // Update additional bookings
        foreach ($additionalBookings as $additionalBooking) {
            $additionalBooking->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_method' => 'test',
                'payment_id' => 'test_' . $paymentIntentId,
                'paid_amount' => $additionalBooking->total_price,
                'paid_at' => now(),
            ]);
        }

        return redirect()->route('payments.success', $booking)
            ->with('success', 'Paiement de test effectué avec succès ! Toutes les réservations sont confirmées.');
    }

    /**
     * Process Stripe payment
     */
    private function processStripePayment(Booking $booking, array $additionalBookings, float $totalAmount, Request $request)
    {
        // Update the payment intent with the new amount
        $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

        // If amount changed, update the payment intent
        if ($paymentIntent->amount !== $totalAmount * 100) {
            $paymentIntent = PaymentIntent::update($paymentIntent->id, [
                'amount' => $totalAmount * 100,
            ]);
        }

        $paymentIntent->confirm([
            'payment_method' => $request->payment_method_id,
        ]);

        if ($paymentIntent->status === 'succeeded') {
            // Update main booking payment status and confirm booking
            $booking->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_method' => 'stripe',
                'payment_id' => $paymentIntent->id,
                'paid_amount' => $totalAmount,
                'paid_at' => now(),
            ]);

            // Update additional bookings
            foreach ($additionalBookings as $additionalBooking) {
                $additionalBooking->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'payment_method' => 'stripe',
                    'payment_id' => $paymentIntent->id,
                    'paid_amount' => $additionalBooking->total_price,
                    'paid_at' => now(),
                ]);
            }

            return redirect()->route('payments.success', $booking)
                ->with('success', 'Paiement effectué avec succès ! Toutes les réservations sont confirmées.');
        } else {
            // If payment failed, delete additional bookings
            foreach ($additionalBookings as $additionalBooking) {
                $additionalBooking->delete();
            }

            return redirect()->route('payments.checkout', $booking)
                ->with('error', 'Le paiement a échoué. Veuillez réessayer.');
        }
    }

    /**
     * Create D17 payment via API
     */
    private function createD17Payment(Booking $booking, float $amount)
    {
        $d17Config = config('services.d17');

        // If D17 is not properly configured, simulate payment for testing
        if (!$d17Config || !isset($d17Config['api_key']) || empty($d17Config['api_key']) ||
            $d17Config['api_key'] === 'your_d17_api_key' || !isset($d17Config['api_url'])) {

            // Simulate successful D17 payment creation
            $paymentData = [
                'payment_id' => 'd17_sim_' . $booking->id . '_' . time(),
                'redirect_url' => route('payments.d17_success', $booking) . '?payment_id=d17_sim_' . $booking->id . '_' . time(),
                'status' => 'created',
                'amount' => $amount,
                'currency' => 'TND'
            ];

            // Store simulated D17 payment ID in booking
            $booking->update([
                'payment_id' => $paymentData['payment_id'],
            ]);

            return $paymentData;
        }

        // Real D17 API integration
        $payload = [
            'api_key' => $d17Config['api_key'],
            'amount' => $amount,
            'currency' => 'TND',
            'order_id' => 'booking_' . $booking->id,
            'customer_email' => auth()->user()->email,
            'customer_phone' => auth()->user()->phone ?? '',
            'success_url' => route('payments.d17_success', $booking),
            'cancel_url' => route('payments.d17_cancel', $booking),
            'webhook_url' => route('payments.d17_webhook'),
            'description' => 'Paiement réservation garage - ' . $booking->service->name,
        ];

        $response = Http::timeout(30)->post($d17Config['api_url'] . '/payments/create', $payload);

        if ($response->successful()) {
            $data = $response->json();

            // Store D17 payment ID in booking for later reference
            $booking->update([
                'payment_id' => $data['payment_id'] ?? null,
            ]);

            return $data;
        } else {
            throw new \Exception('Erreur API D17: ' . $response->body());
        }
    }

}
