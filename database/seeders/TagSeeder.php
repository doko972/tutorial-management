<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Débutant',
            'Intermédiaire',
            'Avancé',
            'Windows',
            'Mac',
            'Linux',
            'Réseau',
            'Sécurité',
            'Logiciel',
            'Matériel',
            'Cloud',
            'Configuration',
            'Dépannage',
            'Guide',
            'Procédure',
            'Formation',
            'Astuce',
            'Excel',
            'Word',
            'PowerPoint',
            'Téléphonie',
            'Centrex',
            'IPBX',
            'Firewall',
            'Trunk',
            'NAT',
            'Omada',
            'Yealink',
            'YMCS',
            'Vision',
            'OVH',
            'Alphalink',
            'Ema',
            'Backup',
            '4G/5G'
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => \Illuminate\Support\Str::slug($tagName),
            ]);
        }
    }
}