<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create(
            'package_updates',
            function (Blueprint $table): void {
                $table->id();
                $table->foreignId('package_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('intro')->nullable();
                $table->longText('content')->nullable();
                $table->timestamp('published_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->json('data')->nullable();
                $table->timestamps();
            },
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('package_updates');
    }
};
