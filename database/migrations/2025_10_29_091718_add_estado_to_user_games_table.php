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
    Schema::create('achievements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_game_id')->constrained()->onDelete('cascade');
        $table->string('titulo');
        $table->text('descripcion')->nullable();
        $table->boolean('completado')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_games', function (Blueprint $table) {
            //
        });
    }
};
