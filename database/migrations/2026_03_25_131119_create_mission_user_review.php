<?php

use App\Models\Mission;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mission_user_review', function (Blueprint $table) {
            $table->foreignIdFor(Mission::class);
            $table->foreignIdFor(User::class);
            $table->boolean("review");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mission_user_review');
    }
};
