<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('image')->nullable();
            $table->decimal('prix_original', 10, 2)->nullable();
            $table->decimal('prix_promo', 10, 2);
            $table->enum('type', ['remise', 'nouveau', 'offre speciale'])->default('remise');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
};
