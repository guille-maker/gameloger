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
    Schema::table('user_games', function (Blueprint $table) {
        $table->string('status')->nullable()->after('game_id'); // ej. empezado, rejugando
        $table->integer('hours_played')->nullable()->after('status'); // ej. 12
        $table->date('started_at')->nullable()->after('hours_played'); // ej. 2025-10-24
    });
}

public function down()
{
    Schema::table('user_games', function (Blueprint $table) {
        $table->dropColumn(['status', 'hours_played', 'started_at']);
    });
}

};
