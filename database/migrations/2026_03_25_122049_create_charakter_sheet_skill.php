<?php

use App\Models\CharakterSheet;
use App\Models\Skill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('charakter_sheet_skill', function (Blueprint $table) {
            $table->foreignIdFor(CharakterSheet::class);
            $table->foreignIdFor(Skill::class);
            $table->integer('level');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charakter_sheet_skill');
    }

};
