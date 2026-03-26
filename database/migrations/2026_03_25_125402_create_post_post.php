<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_post', function (Blueprint $table) {
            $table->foreignIdFor(Post::class);
            $table->foreignIdFor(Post::class, 'quoted_post_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_post');
    }
};
