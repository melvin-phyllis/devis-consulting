<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['user_id', 'nom_entreprise', 'logo', 'cachet', 'adresse', 'telephone', 'telephone2', 'email', 'site_web', 'rccm_cc', 'ncc', 'tva_defaut', 'devise', 'prefixe_entreprise', 'code_ville'];

    protected static function booted(): void
    {
        static::addGlobalScope('user', function (\Illuminate\Database\Eloquent\Builder $builder) {
            if (auth()->check()) {
                $builder->where('user_id', auth()->id());
            }
        });
    }
}
