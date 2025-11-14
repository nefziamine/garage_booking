<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        if ($user->isClient()) {
            return view('profile.client', compact('user'));
        } else {
            return view('profile.garage', compact('user'));
        }
    }

    public function edit()
    {
        $user = Auth::user();
        
        if ($user->isClient()) {
            return view('profile.edit-client', compact('user'));
        } else {
            return view('profile.edit-garage', compact('user'));
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isClient()) {
            return $this->updateClient($request, $user);
        } else {
            return $this->updateGarage($request, $user);
        }
    }

    private function updateClient(Request $request, $user)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès !');
    }

    private function updateGarage(Request $request, $user)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20'],
            'garage_name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'specialties' => ['required', 'array', 'min:1'],
            'experience_years' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'garage_name' => $request->garage_name,
            'city' => $request->city,
            'address' => $request->address,
            'specialties' => $request->specialties,
            'experience_years' => $request->experience_years,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('profile')->with('success', 'Profil garage mis à jour avec succès !');
    }
}
