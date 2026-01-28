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
        Schema::create('planning_historique', function (Blueprint $table) {
           $table->id();

           $table->foreignId('planning_id')
          ->constrained('plannings')
          ->onDelete('cascade');
           $table->string('actor')->default('admin');
           $table->string('action');
           $table->text('comment')->nullable();

           $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planning_historique');
    }
};
