<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'usersinfos'; // Spécifie le nom de la table

    /**
     * Les attributs pouvant être remplis.
     */
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'birthdate',
        'country',
        'city',
        'zip_code',
    ];

    /**
     * Relation avec le modèle User.
     * Chaque UserInfo appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); 
        // 'user_id' = clé étrangère dans `user_infos`
        // 'id' = clé primaire dans `users`
    }
}
