<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fournisseur_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('nombre');
            $table->string('status');
            $table->date('date');
            $table->string('produit')->nullable();
            $table->unsignedBigInteger('emplacement_id');
            $table->foreign('emplacement_id')->references('id')->on('emplacements')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fournisseur_infos');
    }
};
