<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitCaracteristiqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_caracteristique', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produit_id'); // Clé étrangère pour produit
            $table->unsignedBigInteger('caracteristique_id'); // Clé étrangère pour caractéristique
            $table->timestamps();
    
            // Clés étrangères
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade');
            $table->foreign('caracteristique_id')->references('id')->on('caracteristiques')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produit_caracteristique');
    }
}
