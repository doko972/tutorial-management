<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagsByFamily = [
            'Difficulté' => [
                'Débutant',
                'Intermédiaire',
                'Avancé',
            ],
            'Office' => [
                'Word',
                'Excel',
                'PowerPoint',
                'Outlook',
            ],
            'Réseau' => [
                'Configuration',
                'Dépannage',
                'Installation',
                'Sécurité',
            ],
            'Système' => [
                'Windows',
                'Linux',
                'macOS',
            ],
            'Durée' => [
                'Rapide (< 10min)',
                'Moyen (10-30min)',
                'Long (> 30min)',
            ],
        ];

        foreach ($tagsByFamily as $family => $tags) {
            foreach ($tags as $tagName) {
                Tag::create([
                    'name' => $tagName,
                    'slug' => Str::slug($tagName),
                    'family' => $family,
                ]);
            }
        }
    }
}