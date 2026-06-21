<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('threads', function (Blueprint $table) {
            if (!Schema::hasColumn('threads', 'tag')) {
                $table->string('tag')->default('normalny')->after('forum_id');
            }
            if (Schema::hasColumn('threads', 'charakter_id')) {
                $table->dropColumn('charakter_id');
            }
        });

        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'tag')) {
                $table->string('tag')->default('normalny')->after('thread_id');
            }
            $table->unsignedBigInteger('charakter_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('threads', function (Blueprint $table) {
            if (Schema::hasColumn('threads', 'tag')) {
                $table->dropColumn('tag');
            }
        });

        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'tag')) {
                $table->dropColumn('tag');
            }
        });
    }
};
