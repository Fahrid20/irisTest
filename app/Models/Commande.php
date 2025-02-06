<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nom', 'email', 'telephone', 'adresse', 'ville', 'code_postal', 'mode_paiement', 'total', 'statut'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
