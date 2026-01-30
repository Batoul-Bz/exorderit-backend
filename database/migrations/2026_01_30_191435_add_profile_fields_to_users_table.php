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
        Schema::table('users', function (Blueprint $table) {

            $table->string('dateNaissance')->nullable();
            $table->string('familyName')->nullable();
            $table->string('ville')->nullable();
            $table->string('num')->nullable();

            $table->string('functionPoste')->nullable();
            $table->string('lieuTravail')->nullable();
           
            $table->string('expirience')->nullable();
            $table->string('certificate')->nullable();
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
