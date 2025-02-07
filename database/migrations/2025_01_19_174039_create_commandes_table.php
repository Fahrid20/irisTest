<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Utilisateur qui passe la commande
            $table->string('nom');
            $table->string('email');
            $table->string('telephone');
            $table->text('adresse');
            $table->string('ville');
            $table->string('code_postal');
            $table->enum('mode_paiement', ['carte', 'paypal', 'cash']);
            $table->decimal('total', 10, 2); // Total de la commande
            $table->string('statut')->default('en attente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commandes');
    }
};
