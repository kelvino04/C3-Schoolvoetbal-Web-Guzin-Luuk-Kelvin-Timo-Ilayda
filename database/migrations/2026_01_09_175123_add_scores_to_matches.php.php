<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->integer('score1')->nullable();
            $table->integer('score2')->nullable();
            $table->boolean('is_finished')->default(false);
            $table->integer('team1_points')->nullable();
            $table->integer('team2_points')->nullable();
        });
    }

    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropColumn([
                'score1',
                'score2',
                'is_finished',
                'team1_points',
                'team2_points'
            ]);
        });
    }
};
