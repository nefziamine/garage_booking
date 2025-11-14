<?php

namespace Database\Seeders;

use App\Models\Garage;
use App\Models\GarageService;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GarageSeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            'Tunis', 'Ariana', 'Ben Arous', 'La Manouba', 'Zaghouan', 
            'Nabeul', 'Hammamet', 'Bizerte', 'Béja', 'Jendouba',
            'Le Kef', 'Siliana', 'Kairouan', 'Kasserine', 'Sidi Bouzid',
            'Sousse', 'Monastir', 'Mahdia', 'Sfax', 'Gabès',
            'Médenine', 'Tataouine', 'Gafsa', 'Tozeur', 'Kebili'
        ];

        $services = [
            'Vidange' => ['price' => 50, 'duration' => 60],
            'Réparation moteur' => ['price' => 200, 'duration' => 240],
            'Pneus' => ['price' => 80, 'duration' => 90],
            'Électricité' => ['price' => 120, 'duration' => 120],
            'Climatisation' => ['price' => 150, 'duration' => 180],
            'Carrosserie' => ['price' => 300, 'duration' => 360],
            'Diagnostic' => ['price' => 40, 'duration' => 30],
            'Freins' => ['price' => 100, 'duration' => 120],
        ];

        $brands = ['Renault', 'Peugeot', 'Citroën', 'Fiat', 'Volkswagen', 'Toyota', 'Hyundai'];

        for ($i = 1; $i <= 50; $i++) {
            // Créer un utilisateur garage
            $user = User::create([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '+216' . fake()->numberBetween(20000000, 99999999),
                'city' => fake()->randomElement($cities),
                'password' => Hash::make('password'),
                'user_type' => 'garage',
            ]);

            // Créer un garage
            $garage = Garage::create([
                'user_id' => $user->id,
                'name' => fake()->company() . ' Auto',
                'description' => fake()->paragraph(),
                'address' => fake()->address(),
                'city' => $user->city,
                'phone' => $user->phone,
                'email' => $user->email,
                'website' => fake()->optional()->url(),
                'opening_hours' => [
                    'Lundi-Vendredi' => '8h-18h',
                    'Samedi' => '8h-12h',
                    'Dimanche' => 'Fermé'
                ],
                'services' => fake()->randomElements(array_keys($services), fake()->numberBetween(3, 6)),
                'specialties' => fake()->randomElements($brands, fake()->numberBetween(2, 5)),
                'rating' => fake()->randomFloat(1, 3.0, 5.0),
                'total_reviews' => fake()->numberBetween(0, 50),
                'is_verified' => fake()->boolean(80),
                'is_active' => true,
                'latitude' => fake()->latitude(32.0, 37.0),
                'longitude' => fake()->longitude(7.0, 12.0),
            ]);

            // Créer les services du garage
            $garageServices = fake()->randomElements(array_keys($services), fake()->numberBetween(4, 8));
            foreach ($garageServices as $serviceName) {
                $service = $services[$serviceName];
                GarageService::create([
                    'garage_id' => $garage->id,
                    'name' => $serviceName,
                    'description' => fake()->sentence(),
                    'price' => $service['price'] + fake()->numberBetween(-20, 20),
                    'duration' => $service['duration'] + fake()->numberBetween(-30, 30),
                    'is_available' => true,
                    'category' => fake()->randomElement(['Entretien', 'Réparation', 'Diagnostic']),
                ]);
            }
        }
    }
} 