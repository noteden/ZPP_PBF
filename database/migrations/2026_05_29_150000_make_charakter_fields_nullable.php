<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Pola opisowe postaci są opcjonalne w formularzu — dopuszczamy null,
        // by można było utworzyć postać podając tylko imię.
        Schema::table('charakters', function (Blueprint $table) {
            $table->string('age')->nullable()->change();
            $table->string('origin')->nullable()->change();
            $table->string('race')->nullable()->change();
            $table->string('eyes')->nullable()->change();
            $table->string('hair')->nullable()->change();
            $table->string('biography')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('charakters', function (Blueprint $table) {
            $table->string('age')->nullable(false)->change();
            $table->string('origin')->nullable(false)->change();
            $table->string('race')->nullable(false)->change();
            $table->string('eyes')->nullable(false)->change();
            $table->string('hair')->nullable(false)->change();
            $table->string('biography')->nullable(false)->change();
        });
    }
};
