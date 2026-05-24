<?php

use App\Models\Charakter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('charakter_sheets', function (Blueprint $table) {
            $table->id();
            $table->json('statistic');
            $table->foreignIdFor(Charakter::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charakter_sheets');
    }
};
