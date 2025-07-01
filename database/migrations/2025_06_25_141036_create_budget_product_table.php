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
        Schema::create('budget_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('budget_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Precio del producto al momento del presupuesto
            $table->string('notes', 100)->nullable(); // Notas adicionales

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_product');
    }
};
