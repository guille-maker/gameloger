<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_games', function (Blueprint $table) {
    // Solo añadir las que realmente faltan
    if (!Schema::hasColumn('user_games', 'started_at')) {
        $table->date('started_at')->nullable()->after('completed');
    }
    if (!Schema::hasColumn('user_games', 'finished_at')) {
        $table->date('finished_at')->nullable()->after('started_at');
    }
    if (!Schema::hasColumn('user_games', 'status')) {
        $table->enum('status', ['jugando','pausa','terminado','rejugando'])->default('jugando')->after('finished_at');
    }
});

    }

    public function down(): void
    {
        Schema::table('user_games', function (Blueprint $table) {
            $table->dropColumn(['hours_played','difficulty','progress','completed','started_at','finished_at','status']);
        });
    }
};
