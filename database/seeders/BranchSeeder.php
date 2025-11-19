<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        // Technique
        $technique = Branch::create([
            'name' => 'Technique',
            'slug' => 'technique',
            'description' => 'Support technique et infrastructure',
            'color' => '#f59e0b',
            'parent_id' => null,
        ]);

        Branch::create([
            'name' => 'Réseau',
            'slug' => 'reseau',
            'description' => 'Configuration et maintenance réseau',
            'color' => '#f59e0b',
            'parent_id' => $technique->id,
        ]);

        Branch::create([
            'name' => 'Système',
            'slug' => 'systeme',
            'description' => 'Administration système',
            'color' => '#f59e0b',
            'parent_id' => $technique->id,
        ]);

        Branch::create([
            'name' => 'Téléphonie',
            'slug' => 'telephonie',
            'description' => 'VoIP et téléphonie',
            'color' => '#f59e0b',
            'parent_id' => $technique->id,
        ]);

        // Administratif
        $administratif = Branch::create([
            'name' => 'Administratif',
            'slug' => 'administratif',
            'description' => 'Gestion administrative',
            'color' => '#3b82f6',
            'parent_id' => null,
        ]);

        Branch::create([
            'name' => 'RH',
            'slug' => 'rh',
            'description' => 'Ressources humaines',
            'color' => '#3b82f6',
            'parent_id' => $administratif->id,
        ]);

        Branch::create([
            'name' => 'Juridique',
            'slug' => 'juridique',
            'description' => 'Affaires juridiques',
            'color' => '#3b82f6',
            'parent_id' => $administratif->id,
        ]);

        // Comptabilité
        $comptabilite = Branch::create([
            'name' => 'Comptabilité',
            'slug' => 'comptabilite',
            'description' => 'Gestion comptable et financière',
            'color' => '#10b981',
            'parent_id' => null,
        ]);

        Branch::create([
            'name' => 'Facturation',
            'slug' => 'facturation',
            'description' => 'Gestion de la facturation',
            'color' => '#10b981',
            'parent_id' => $comptabilite->id,
        ]);

        Branch::create([
            'name' => 'Trésorerie',
            'slug' => 'tresorerie',
            'description' => 'Gestion de trésorerie',
            'color' => '#10b981',
            'parent_id' => $comptabilite->id,
        ]);

        // Commercial
        $commercial = Branch::create([
            'name' => 'Commercial',
            'slug' => 'commercial',
            'description' => 'Ventes et relation client',
            'color' => '#ef4444',
            'parent_id' => null,
        ]);

        Branch::create([
            'name' => 'Ventes',
            'slug' => 'ventes',
            'description' => 'Équipe de vente',
            'color' => '#ef4444',
            'parent_id' => $commercial->id,
        ]);

        Branch::create([
            'name' => 'SAV',
            'slug' => 'sav',
            'description' => 'Service après-vente',
            'color' => '#ef4444',
            'parent_id' => $commercial->id,
        ]);
    }
}