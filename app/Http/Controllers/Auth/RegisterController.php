<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Garage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function registerClient(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:255'],
            'preferred_brands' => ['nullable', 'array'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'specialties' => $request->preferred_brands,
            'password' => Hash::make($request->password),
            'user_type' => 'client',
        ]);

        Auth::login($user);

        return redirect()->route('profile')->with('success', 'Compte client créé avec succès ! Bienvenue sur GarageBooking.');
    }

    public function registerGarage(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'garage_name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'specialties' => ['required', 'array', 'min:1'],
            'services' => ['nullable', 'array'],
            'custom_specialties' => ['nullable', 'array'],
            'experience_years' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ]);

        // Combiner les spécialités standard et personnalisées
        $allSpecialties = $request->specialties;
        if ($request->custom_specialties) {
            $allSpecialties = array_merge($allSpecialties, $request->custom_specialties);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'garage_name' => $request->garage_name,
            'city' => $request->city,
            'address' => $request->address,
            'specialties' => $allSpecialties,
            'experience_years' => $request->experience_years,
            'password' => Hash::make($request->password),
            'user_type' => 'garage',
        ]);

        // Créer le garage avec les services
        $garage = Garage::create([
            'user_id' => $user->id,
            'name' => $request->garage_name,
            'description' => 'Garage spécialisé dans ' . implode(', ', array_slice($allSpecialties, 0, 3)),
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
            'email' => $request->email,
            'services' => $request->services ?? [],
            'specialties' => $allSpecialties,
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('profile')->with('success', 'Compte garage créé avec succès ! Votre garage est maintenant visible sur GarageBooking.');
    }
}
