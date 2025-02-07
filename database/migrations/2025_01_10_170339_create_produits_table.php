<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Nom du produit
            $table->int('stock'); // stock du produit
            $table->decimal('prix', 8, 2); // Prix du produit
            $table->string('image'); // Chemin de l'image du produit
            $table->unsignedBigInteger('categorie'); // Clé étrangère pour la catégorie
            $table->timestamps();
    
            // Clé étrangère
            $table->foreign('categorie')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produits');
    }
}
