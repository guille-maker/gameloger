<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            if (!Schema::hasColumn('games', 'title')) {
                $table->string('title')->nullable()->after('id');
            }

            if (!Schema::hasColumn('games', 'description')) {
                $table->text('description')->nullable()->after('title');
            }

            if (!Schema::hasColumn('games', 'cover_url')) {
                $table->string('cover_url')->nullable()->after('description');
            }

            if (!Schema::hasColumn('games', 'slug')) {
                $table->string('slug')->unique()->after('cover_url');
            }

            if (!Schema::hasColumn('games', 'progress')) {
                $table->integer('progress')->default(0)->after('slug');
            }

            if (!Schema::hasColumn('games', 'status')) {
                $table->enum('status', ['in_progress', 'completed', 'wishlist'])->default('wishlist')->after('progress');
            }
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'cover_url', 'slug', 'progress', 'status']);
        });
    }
};
