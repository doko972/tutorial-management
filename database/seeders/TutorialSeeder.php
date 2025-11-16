<?php

namespace Database\Seeders;

use App\Models\Tutorial;
use App\Models\User;
use App\Models\Branch;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TutorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();
        $tags = Tag::all();

        // Titres de tutoriels par branche
        $tutorialsByBranch = [
            'administratif' => [
                'Guide de gestion des congés',
                'Procédure de demande de fournitures',
                'Comment utiliser le système de pointage',
                'Gestion des notes de frais',
                'Réservation des salles de réunion',
            ],
            'comptabilite' => [
                'Saisie des factures fournisseurs',
                'Rapprochement bancaire mensuel',
                'Déclaration de TVA',
                'Gestion des immobilisations',
                'Clôture comptable annuelle',
            ],
            'technique' => [
                'Installation de Windows 11',
                'Configuration du VPN entreprise',
                'Dépannage imprimante réseau',
                'Mise à jour du parc informatique',
                'Gestion des sauvegardes',
                'Configuration Office 365',
                'Sécurité informatique - Bonnes pratiques',
            ],
            'commercial' => [
                'Utilisation du CRM',
                'Processus de qualification des leads',
                'Gestion des devis',
                'Suivi des opportunités',
                'Reporting commercial',
            ],
        ];

        $descriptions = [
            'Ce tutoriel détaillé vous guidera pas à pas dans la réalisation de cette tâche.',
            'Un guide complet pour maîtriser cette fonctionnalité essentielle.',
            'Apprenez les meilleures pratiques et astuces pour optimiser votre travail.',
            'Tout ce que vous devez savoir pour être autonome sur cette procédure.',
            'Un tutoriel simple et efficace pour gagner du temps au quotidien.',
        ];

        $fileTypes = ['text', 'document', 'pdf', 'video'];

        foreach ($branches as $branch) {
            $branchSlug = $branch->slug;
            
            if (!isset($tutorialsByBranch[$branchSlug])) {
                continue;
            }

            // Récupérer les utilisateurs de cette branche
            $users = User::where('branch_id', $branch->id)->get();
            
            if ($users->isEmpty()) {
                continue;
            }

            foreach ($tutorialsByBranch[$branchSlug] as $title) {
                $tutorial = Tutorial::create([
                    'branch_id' => $branch->id,
                    'user_id' => $users->random()->id,
                    'title' => $title,
                    'slug' => \Illuminate\Support\Str::slug($title),
                    'description' => $descriptions[array_rand($descriptions)],
                    'content' => "# Introduction\n\nCeci est un tutoriel de démonstration.\n\n## Étape 1\n\nPremière étape détaillée...\n\n## Étape 2\n\nDeuxième étape avec des explications...\n\n## Conclusion\n\nVous savez maintenant comment procéder !",
                    'file_type' => $fileTypes[array_rand($fileTypes)],
                    'is_published' => true,
                    'published_at' => now()->subDays(rand(1, 30)),
                    'views_count' => rand(5, 150),
                ]);

                // Attacher 2-4 tags aléatoires
                if ($tags->count() > 0) {
                    $tutorial->tags()->attach(
                        $tags->random(rand(2, min(4, $tags->count())))->pluck('id')->toArray()
                    );
                }
            }
        }
    }
}