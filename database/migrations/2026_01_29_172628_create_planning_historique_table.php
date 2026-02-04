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

          $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
          
          $table->text('comment')->nullable();

          $table->enum('action', ['accepted','refused','published']);

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
