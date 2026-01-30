<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('user_games', function (Blueprint $table) {
        $table->string('status')->nullable();
        $table->integer('hours_played')->nullable();
        $table->timestamp('started_at')->nullable();
        $table->timestamp('finished_at')->nullable();
    });
}

public function down()
{
    Schema::table('user_games', function (Blueprint $table) {
        $table->dropColumn(['status', 'hours_played', 'started_at', 'finished_at']);
    });
}

};
