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
        Schema::create('Plannings', function (Blueprint $table) {
            $table->id();
            $table->string('niveau');        
            $table->string('groupe');        
            $table->string('enseignant');  
            $table->string('module');       
            $table->string('jour');          
            $table->string('heure');        
            $table->string('salle');
            $table->enum('statut', ['draft','published'])->default('draft');
            $table->string('action')->nullable(); 
            $table->json('visible_to');      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Plannings');
    }
};
