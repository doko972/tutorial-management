<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@hrttelecoms.fr',
            'password' => Hash::make('password'), // Change ce mot de passe en production !
            'role' => 'admin',
            'branch_id' => null, // L'admin n'a pas de branche spécifique
        ]);

        // Créer un utilisateur manager pour chaque branche
        $branches = Branch::all();
        
        foreach ($branches as $branch) {
            User::create([
                'name' => 'Manager ' . $branch->name,
                'email' => 'manager.' . $branch->slug . '@hrttelecoms.fr',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'branch_id' => $branch->id,
            ]);
        }

        // Créer un utilisateur normal pour chaque branche
        foreach ($branches as $branch) {
            User::create([
                'name' => 'Utilisateur ' . $branch->name,
                'email' => 'user.' . $branch->slug . '@hrttelecoms.fr',
                'password' => Hash::make('password'),
                'role' => 'user',
                'branch_id' => $branch->id,
            ]);
        }
    }
}