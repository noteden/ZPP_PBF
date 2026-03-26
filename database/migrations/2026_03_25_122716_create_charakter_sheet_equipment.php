<?php

use App\Models\CharakterSheet;
use App\Models\Equipment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('charakter_sheet_equipment', function (Blueprint $table) {
            $table->foreignIdFor(CharakterSheet::class);
            $table->foreignIdFor(Equipment::class);
            $table->integer('number');
            $table->boolean('is_equipped');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charakter_sheet_equipment');
    }
};
