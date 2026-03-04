<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['user_id', 'type', 'numero', 'client_id', 'date_emission', 'objet', 'lieu', 'titre_document', 'taux_tva', 'statut', 'total_ht', 'total_tva', 'total_ttc'];

    protected static function booted()
    {
        static::addGlobalScope('user', function (\Illuminate\Database\Eloquent\Builder $builder) {
            if (auth()->check()) {
                $builder->where('user_id', auth()->id());
            }
        });
    }

    /**
     * Génère un numéro de document au format : YAC-DV-ABJ-2026-0023
     * @param string $type 'devis' ou 'facture'
     * @return string
     */
    public static function genererNumero(string $type): string
    {
        $settings = Setting::first();
        $prefixe = $settings->prefixe_entreprise ?? 'YAC';
        $ville = $settings->code_ville ?? 'ABJ';
        $annee = now()->format('Y');

        // Code type : DV pour devis, FAC pour facture
        $codeType = $type === 'devis' ? 'DV' : 'FAC';

        // Compter les documents de ce type pour l'année en cours (sans le scope user)
        $count = static::withoutGlobalScope('user')
            ->where('type', $type)
            ->whereYear('created_at', $annee)
            ->count();

        // Numéro séquentiel sur 4 chiffres
        $sequence = str_pad($count + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefixe}-{$codeType}-{$ville}-{$annee}-{$sequence}";
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function lignes()
    {
        return $this->hasMany(DocumentLigne::class);
    }

    /**
     * Convertit le montant TTC en lettres (français)
     * @return string
     */
    public function getMontantEnLettresAttribute(): string
    {
        return self::nombreEnLettres((int) $this->total_ttc) . ' francs CFA';
    }

    /**
     * Convertit un nombre en lettres (français)
     */
    public static function nombreEnLettres(int $nombre): string
    {
        if ($nombre == 0)
            return 'zéro';

        $unites = ['', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'];
        $dizaines = ['', '', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante', 'quatre-vingt', 'quatre-vingt'];

        $resultat = '';

        // Milliards
        if ($nombre >= 1000000000) {
            $milliards = (int) ($nombre / 1000000000);
            $resultat .= ($milliards > 1 ? self::nombreEnLettres($milliards) . ' ' : '') . 'milliard' . ($milliards > 1 ? 's' : '') . ' ';
            $nombre %= 1000000000;
        }

        // Millions
        if ($nombre >= 1000000) {
            $millions = (int) ($nombre / 1000000);
            $resultat .= ($millions > 1 ? self::nombreEnLettres($millions) . ' ' : 'un ') . 'million' . ($millions > 1 ? 's' : '') . ' ';
            $nombre %= 1000000;
        }

        // Milliers
        if ($nombre >= 1000) {
            $milliers = (int) ($nombre / 1000);
            if ($milliers == 1) {
                $resultat .= 'mille ';
            } else {
                $resultat .= self::nombreEnLettres($milliers) . ' mille ';
            }
            $nombre %= 1000;
        }

        // Centaines
        if ($nombre >= 100) {
            $centaines = (int) ($nombre / 100);
            if ($centaines == 1) {
                $resultat .= 'cent ';
            } else {
                $resultat .= $unites[$centaines] . ' cents ';
            }
            $nombre %= 100;
        }

        // Dizaines et unités
        if ($nombre >= 20) {
            $dizaine = (int) ($nombre / 10);
            $unite = $nombre % 10;

            if ($dizaine == 7 || $dizaine == 9) {
                $resultat .= $dizaines[$dizaine] . '-' . $unites[10 + $unite];
            } else {
                $resultat .= $dizaines[$dizaine];
                if ($unite == 1 && $dizaine != 8) {
                    $resultat .= '-et-un';
                } elseif ($unite > 0) {
                    $resultat .= '-' . $unites[$unite];
                } elseif ($dizaine == 8) {
                    $resultat .= 's';
                }
            }
        } elseif ($nombre > 0) {
            $resultat .= $unites[$nombre];
        }

        return trim($resultat);
    }
}
