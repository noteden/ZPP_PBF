<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Misje: kto zgłosił i status werdyktu (spec: zgłaszanie misji + ocena).
        Schema::table('missions', function (Blueprint $table) {
            if (!Schema::hasColumn('missions', 'proposed_by')) {
                $table->foreignIdFor(User::class, 'proposed_by')->nullable()->after('description');
            }
            if (!Schema::hasColumn('missions', 'status')) {
                $table->string('status')->default('proposed')->after('proposed_by');
            }
        });

        // Ocena misji przez role werdyktujące (1-5).
        Schema::table('mission_user_review', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_user_review', 'rating')) {
                $table->unsignedTinyInteger('rating')->nullable();
            }
        });

        // Dokumenty: załączniki (mapy/PDF/grafiki) oraz kategoria (lore, mechanika, regulamin).
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'file_path')) {
                $table->string('file_path')->nullable()->after('content');
            }
            if (!Schema::hasColumn('documents', 'category')) {
                $table->string('category')->nullable()->after('file_path');
            }
        });

        // Logi światowe / kronika historii świata.
        if (!Schema::hasTable('world_logs')) {
            Schema::create('world_logs', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->longText('body');
                $table->date('occurred_on')->nullable();
                $table->foreignIdFor(User::class)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn(['proposed_by', 'status']);
        });

        Schema::table('mission_user_review', function (Blueprint $table) {
            $table->dropColumn('rating');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'category']);
        });

        Schema::dropIfExists('world_logs');
    }
};
