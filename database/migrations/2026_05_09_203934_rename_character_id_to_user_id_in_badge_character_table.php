<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('badge_character', function (Blueprint $table) {
            // Zmiana nazwy kolumny
            $table->renameColumn('character_id', 'user_id');
        });

        // Opcjonalnie: zmiana nazwy samej tabeli, jeśli chcesz być bardzo porządny
        Schema::rename('badge_character', 'badge_user');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('badge_character', function (Blueprint $table) {
            //
        });
    }
};
