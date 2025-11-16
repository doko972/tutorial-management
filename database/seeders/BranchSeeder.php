<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Administratif',
                'slug' => 'administratif',
                'color' => '#3b82f6', // Bleu
                'icon' => 'briefcase',
                'description' => 'Tutoriels pour le service administratif',
            ],
            [
                'name' => 'Comptabilité',
                'slug' => 'comptabilite',
                'color' => '#10b981', // Vert
                'icon' => 'calculator',
                'description' => 'Tutoriels pour le service comptabilité',
            ],
            [
                'name' => 'Technique',
                'slug' => 'technique',
                'color' => '#f59e0b', // Orange
                'icon' => 'wrench',
                'description' => 'Tutoriels pour le service technique',
            ],
            [
                'name' => 'Commercial',
                'slug' => 'commercial',
                'color' => '#ef4444', // Rouge
                'icon' => 'users',
                'description' => 'Tutoriels pour le service commercial',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}