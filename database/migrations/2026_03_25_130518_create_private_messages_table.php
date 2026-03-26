<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('private_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'sender_user_id');
            $table->foreignIdFor(User::class, 'receiver_user_id');
            $table->longText('content');
            $table->boolean('is_read');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('private_messages');
    }
};
