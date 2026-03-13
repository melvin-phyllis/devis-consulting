<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Document;
use App\Models\DocumentLigne;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FacturesDemoSeeder extends Seeder
{
    /**
     * Crée 100 factures sur 10 mois pour phyllismelvin000@gmail.com
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'phyllismelvin000@gmail.com'],
            [
                'name' => 'Phyllis Melvin',
                'password' => Hash::make('password'),
            ]
        );

        $clients = $this->ensureClients($user);

        $designations = [
            'Consulting stratégie',
            'Audit technique',
            'Formation équipe',
            'Développement sur mesure',
            'Maintenance annuelle',
            'Conseil organisation',
            'Étude de faisabilité',
            'Support technique',
        ];

        $statuts = ['payé', 'en attente', 'en attente', 'en attente']; // 1/4 payées

        $prefixe = 'YAC-FAC-ABJ-';
        $factureId = 1;

        // 10 mois : de juin 2025 à mars 2026
        for ($m = 0; $m < 10; $m++) {
            $date = now()->subMonths(9 - $m);
            $year = $date->format('Y');
            $month = $date->format('m');
            $ym = $year . $month;

            for ($i = 1; $i <= 10; $i++) {
                $numero = $prefixe . $ym . '-' . str_pad((string) $i, 4, '0', STR_PAD_LEFT);

                // Éviter doublon si seeder relancé : vérifier si ce numéro existe déjà pour ce user
                if (Document::withoutGlobalScope('user')->where('numero', $numero)->exists()) {
                    continue;
                }

                $client = $clients->random();
                $day = rand(1, min(28, (int) $date->daysInMonth));
                $dateEmission = $date->copy()->day($day);

                $totalHt = rand(150, 500) * 1000; // 150k à 500k FCFA
                $tauxTva = 0.18;
                $totalTva = round($totalHt * $tauxTva, 2);
                $totalTtc = $totalHt + $totalTva;

                $doc = Document::withoutGlobalScope('user')->create([
                    'user_id' => $user->id,
                    'type' => 'facture',
                    'numero' => $numero,
                    'client_id' => $client->id,
                    'date_emission' => $dateEmission,
                    'objet' => 'Prestation de services ' . $dateEmission->format('F Y'),
                    'titre_document' => 'FACTURE',
                    'taux_tva' => 18,
                    'statut' => $statuts[array_rand($statuts)],
                    'total_ht' => $totalHt,
                    'total_tva' => $totalTva,
                    'total_ttc' => $totalTtc,
                ]);

                $designation = $designations[array_rand($designations)];
                DocumentLigne::create([
                    'document_id' => $doc->id,
                    'designation' => $designation,
                    'quantite' => 1,
                    'prix_unitaire' => $totalHt,
                ]);

                $factureId++;
            }
        }

        $this->command->info('100 factures créées pour ' . $user->email . ' (10 mois × 10 factures).');
    }

    private function ensureClients(User $user): \Illuminate\Support\Collection
    {
        $raisons = [
            'Société Alpha SARL',
            'Entreprise Beta & Cie',
            'Groupe Gamma SA',
            'Solutions Delta',
            'Tech Epsilon',
        ];

        $clients = collect();
        foreach ($raisons as $raison) {
            $clients->push(Client::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'raison_sociale' => $raison,
                ],
                [
                    'adresse' => rand(1, 99) . ' rue des Entreprises, Abidjan',
                    'telephone' => '+225 07 ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99) . ' ' . rand(10, 99),
                    'email' => strtolower(str_replace(' ', '', $raison)) . '@demo.ci',
                ]
            ));
        }

        return $clients;
    }
}
