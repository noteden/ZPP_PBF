<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('charakters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('age');
            $table->string('origin');
            $table->string('race');
            $table->string('eyes');
            $table->string('hair');
            $table->string('biography');
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charakters');
    }
};
