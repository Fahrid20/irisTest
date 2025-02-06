<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class UsersInfos extends Migration
{
    public function up()
    {
        Schema::create('usersInfos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // Lien vers la table users
            $table->string('phone', 15)->nullable();
            $table->string('address', 255)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable(); // code postal
            $table->timestamps();

            // Définir une clé étrangère pour garantir l'intégrité
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usersInfos');
    }

    
}

