<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = ['nom','stock', 'prix', 'image', 'categorie'];

    // Relation avec la catégorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // Relation avec les caractéristiques
    public function caracteristiques()
    {
        return $this->belongsToMany(Caracteristique::class, 'produit_caracteristique');
    }


        public function caracteristique()
    {
        return $this->hasOne(Caracteristique::class, 'id');
    }

}


