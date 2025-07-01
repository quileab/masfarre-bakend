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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            // Usuario que creó el presupuesto (admin)
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            // Usuario cliente al que va dirigido el presupuesto
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');

            $table->string('name', 100);
            $table->date('date')->default(now());
            // unir con categoria
            $table->foreignId('event_type_id')->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->text('notes')->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('status', ['draft', 'sent', 'approved', 'rejected'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
