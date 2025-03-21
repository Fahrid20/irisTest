<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristique extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'couleur', 'marque', 'waterproof'];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_caracteristique');
    }
}
