<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'posts',
            function (Blueprint $table): void {
                $table->id();
                $table->foreignId('category_id')->constrained();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('intro')->nullable();
                $table->longText('content')->nullable();
                $table->timestamp('published_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->json('data')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
}
