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
        Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('designation');             // Nom de l'article
    $table->string('reference')->unique(); // Référence
    $table->string('category')->nullable(); // Catégorie
    $table->integer('quantity')->default(0); // Quantité actuelle
    $table->integer('min_stock')->default(5); // Seuil minimum (Alerte)
    $table->string('location')->nullable(); // Emplacement
    $table->string('supplier')->nullable(); // Fournisseur
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
