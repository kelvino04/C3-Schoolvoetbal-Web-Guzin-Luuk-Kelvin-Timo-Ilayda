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
        Schema::create('matches', function (Blueprint $table) {
        $table->id();
        $table->foreignId('team1_id')->constrained('teams');
        $table->foreignId('team2_id')->constrained('teams');
        $table->dateTime('start_time');  
        $table->integer('duration');   
        $table->dateTime('referee');  
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
