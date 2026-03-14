<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['document_id', 'montant', 'date_paiement', 'mode_paiement', 'reference'];

    protected function casts(): array
    {
        return [
            'date_paiement' => 'date',
            'montant' => 'decimal:2',
        ];
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
