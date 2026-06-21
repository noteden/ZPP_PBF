<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'approved')) {
                $table->boolean('approved')->default(false)->after('role');
            }
            if (!Schema::hasColumn('users', 'last_seen_at')) {
                $table->timestamp('last_seen_at')->nullable()->after('approved');
            }
        });

        // Istniejące konta uznajemy za zatwierdzone, by nie zablokować adminów/MG.
        DB::table('users')->update(['approved' => true]);

        Schema::table('charakters', function (Blueprint $table) {
            if (!Schema::hasColumn('charakters', 'avatar')) {
                $table->string('avatar')->nullable()->after('hair');
            }
            if (!Schema::hasColumn('charakters', 'experience')) {
                $table->unsignedInteger('experience')->default(0)->after('biography');
            }
            if (!Schema::hasColumn('charakters', 'history_points')) {
                $table->unsignedInteger('history_points')->default(0)->after('experience');
            }
        });

        Schema::table('threads', function (Blueprint $table) {
            if (!Schema::hasColumn('threads', 'archived')) {
                $table->boolean('archived')->default(false)->after('tag');
            }
        });

        // activity_logs.user_id powinien dopuszczać null (akcje systemowe).
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['approved', 'last_seen_at']);
        });

        Schema::table('charakters', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'experience', 'history_points']);
        });

        Schema::table('threads', function (Blueprint $table) {
            $table->dropColumn('archived');
        });
    }
};
