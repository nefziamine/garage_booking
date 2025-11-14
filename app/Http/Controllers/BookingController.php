<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Garage;
use App\Models\GarageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{


    public function index(Request $request)
    {
        $query = Auth::user()->bookings()->with(['garage', 'service']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    public function received(Request $request)
    {
        // Get bookings for garages owned by the current user
        $query = Booking::whereHas('garage', function ($q) {
            $q->where('user_id', Auth::id());
        })->with(['user', 'garage', 'service']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10);
        return view('bookings.received', compact('bookings'));
    }

    public function create(Garage $garage)
    {
        // Prevent users from booking their own garage
        if ($garage->user_id === Auth::id()) {
            return redirect()->route('garages.index')
                ->with('error', 'Vous ne pouvez pas réserver dans votre propre garage.');
        }

        // Get services from the GarageService relationship
        $services = GarageService::where('garage_id', $garage->id)
            ->where('is_available', true)
            ->get();

        // If no services in GarageService table, create from garage's services array
        if ($services->isEmpty() && is_array($garage->services) && !empty($garage->services)) {
            $services = collect($garage->services)->map(function ($serviceName, $index) {
                return (object) [
                    'id' => 'temp_' . $index,
                    'name' => $serviceName,
                    'price' => rand(50, 300), // Default price
                    'duration' => rand(30, 240), // Default duration in minutes
                    'is_available' => true,
                ];
            });
        }

        return view('bookings.create', compact('garage', 'services'));
    }

    public function store(Request $request, Garage $garage)
    {
        // Prevent users from booking their own garage
        if ($garage->user_id === Auth::id()) {
            return redirect()->route('garages.index')
                ->with('error', 'Vous ne pouvez pas réserver dans votre propre garage.');
        }

        $request->validate([
            'service_id' => 'required',
            'booking_date' => 'required|date|after:today',
            'booking_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:500',
            'vehicle_info' => 'required|array',
            'vehicle_info.brand' => 'required|string',
            'vehicle_info.model' => 'required|string',
            'vehicle_info.year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'additional_services' => 'nullable|array',
            'additional_services.*' => 'string',
        ]);

        // Handle both real GarageService and temporary services
        if (str_starts_with($request->service_id, 'temp_')) {
            // Temporary service from garage's services array - create the GarageService record
            $serviceIndex = str_replace('temp_', '', $request->service_id);
            $serviceName = $garage->services[$serviceIndex] ?? 'Service';

            $service = GarageService::create([
                'garage_id' => $garage->id,
                'name' => $serviceName,
                'description' => 'Service ajouté automatiquement',
                'price' => rand(50, 300), // Default price
                'duration' => rand(30, 240), // Default duration in minutes
                'is_available' => true,
                'category' => 'Service général',
            ]);
        } else {
            $service = GarageService::findOrFail($request->service_id);
        }

        // Create main booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'garage_id' => $garage->id,
            'service_id' => $service->id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status' => Booking::STATUS_PENDING,
            'notes' => $request->notes,
            'total_price' => $service->price,
            'vehicle_info' => $request->vehicle_info,
            'estimated_duration' => $service->duration,
            'payment_status' => 'pending',
        ]);

        $allBookings = collect([$booking]);

        // Create additional bookings if additional services are selected
        if ($request->has('additional_services') && is_array($request->additional_services)) {
            foreach ($request->additional_services as $additionalServiceId) {
                // Handle both real GarageService and temporary services
                if (str_starts_with($additionalServiceId, 'temp_')) {
                    $serviceIndex = str_replace('temp_', '', $additionalServiceId);
                    $serviceName = $garage->services[$serviceIndex] ?? 'Service complémentaire';

                    $additionalService = GarageService::create([
                        'garage_id' => $garage->id,
                        'name' => $serviceName,
                        'description' => 'Service complémentaire ajouté automatiquement',
                        'price' => rand(50, 300),
                        'duration' => rand(30, 240),
                        'is_available' => true,
                        'category' => 'Service complémentaire',
                    ]);
                } else {
                    $additionalService = GarageService::findOrFail($additionalServiceId);
                }

                $additionalBooking = Booking::create([
                    'user_id' => Auth::id(),
                    'garage_id' => $garage->id,
                    'service_id' => $additionalService->id,
                    'booking_date' => $request->booking_date,
                    'booking_time' => $request->booking_time,
                    'status' => Booking::STATUS_PENDING,
                    'notes' => 'Service complémentaire - ' . $request->notes,
                    'total_price' => $additionalService->price,
                    'vehicle_info' => $request->vehicle_info,
                    'estimated_duration' => $additionalService->duration,
                    'payment_status' => 'pending',
                ]);

                $allBookings->push($additionalBooking);
            }
        }

        // If multiple bookings, redirect to multi-payment page
        if ($allBookings->count() > 1) {
            // Store booking IDs in session for multi-payment
            session(['multi_payment_bookings' => $allBookings->pluck('id')->toArray()]);
            return redirect()->route('payments.multi_checkout')
                ->with('success', 'Réservations créées. Veuillez procéder au paiement pour confirmer.');
        }

        // Single booking - redirect to normal payment
        return redirect()->route('payments.checkout', $booking)
            ->with('success', 'Réservation créée. Veuillez procéder au paiement pour confirmer.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        // If booking is pending payment, redirect to payment page
        if ($booking->status === 'pending' && $booking->payment_status === 'pending') {
            return redirect()->route('payments.checkout', $booking)
                ->with('info', 'Votre réservation nécessite un paiement pour être confirmée.');
        }

        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);

        if ($booking->status !== Booking::STATUS_PENDING) {
            return back()->with('error', 'Cette réservation ne peut plus être annulée.');
        }

        $booking->update(['status' => Booking::STATUS_CANCELLED]);

        return redirect()->route('bookings.index')
            ->with('success', 'Réservation annulée avec succès.');
    }

    public function confirm(Booking $booking)
    {
        // Check if user owns the garage
        if ($booking->garage->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à confirmer cette réservation.');
        }

        // Allow confirming pending bookings or paid bookings (automatic confirmation on payment)
        if ($booking->status === 'cancelled' || $booking->status === 'completed') {
            return back()->with('error', 'Cette réservation ne peut plus être confirmée.');
        }

        // If booking is already confirmed (paid), just show success
        if ($booking->status === 'confirmed') {
            return back()->with('success', 'Cette réservation est déjà confirmée.');
        }

        $booking->update(['status' => 'confirmed']);

        return redirect()->route('bookings.received')
            ->with('success', 'Réservation confirmée avec succès.');
    }

    public function complete(Booking $booking)
    {
        // Check if user owns the garage
        if ($booking->garage->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à marquer cette réservation comme terminée.');
        }

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Cette réservation ne peut pas être marquée comme terminée.');
        }

        $booking->update(['status' => 'completed']);

        return redirect()->route('bookings.received')
            ->with('success', 'Réservation marquée comme terminée.');
    }

    /**
     * Prepare payment page with recommendations
     */
    public function preparePayment(Request $request)
    {
        // If accessed via GET without data, redirect to welcome
        if ($request->method() === 'GET' && !$request->has('service_id')) {
            return redirect()->route('welcome')->with('error', 'Veuillez créer une réservation depuis la page du garage.');
        }

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

        // Get recommended services
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

        $recommendedServices = app(PaymentController::class)->getRecommendedServices($tempBooking);

        return view('bookings.prepare-payment', compact(
            'garage',
            'service',
            'tempBooking',
            'recommendedServices',
            'request'
        ));
    }
}