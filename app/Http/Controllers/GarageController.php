<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use App\Models\GarageService;
use Illuminate\Http\Request;

class GarageController extends Controller
{
    public function index(Request $request)
    {
        $query = Garage::with(['user', 'services', 'reviews'])
            ->where('is_active', true);

        // Recherche textuelle
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('address', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filtres
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('service')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->service . '%');
            });
        }

        if ($request->filled('brand')) {
            $query->whereJsonContains('specialties', $request->brand);
        }

        $garages = $query->with('services')->paginate(12);

        // Statistiques par ville
        $cityStats = Garage::where('is_active', true)
            ->selectRaw('city, COUNT(*) as count')
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->get();

        return view('garages.index', compact('garages', 'cityStats'));
    }

    public function show(Garage $garage)
    {
        $garage->load(['user', 'services' => function ($query) {
            $query->where('is_available', true);
        }, 'reviews' => function ($query) {
            $query->where('is_approved', true)->latest();
        }]);

        $reviews = $garage->reviews()->with('user')->latest()->paginate(5);
        
        return view('garages.show', compact('garage', 'reviews'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:255',
            'city' => 'nullable|string',
            'service' => 'nullable|string',
            'brand' => 'nullable|string',
        ]);

        return $this->index($request);
    }
}
