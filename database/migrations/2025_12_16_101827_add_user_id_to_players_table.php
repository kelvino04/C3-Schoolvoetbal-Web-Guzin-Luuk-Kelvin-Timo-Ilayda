<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('players', 'user_id')) {
            Schema::table('players', function ($table) {
                $table->foreignId('user_id')->nullable()->after('team_id')->constrained()->nullOnDelete();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('players', 'user_id')) {
            Schema::table('players', function ($table) {
                $table->dropColumn('user_id');
            });
        }
    }

};
