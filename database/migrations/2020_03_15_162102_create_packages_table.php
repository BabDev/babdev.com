<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create(
            'packages',
            function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('display_name');
                $table->string('packagist_name')->nullable();
                $table->string('slug')->unique();
                $table->string('logo')->nullable();
                $table->text('description')->nullable();
                $table->json('topics')->nullable();
                $table->boolean('has_documentation')->default(false);
                $table->json('docs_branches')->nullable();
                $table->string('default_docs_version')->nullable();
                $table->string('package_type')->nullable();
                $table->integer('stars')->default(0);
                $table->integer('downloads')->nullable();
                $table->string('language')->nullable();
                $table->boolean('supported')->default(true);
                $table->boolean('visible')->default(true);
                $table->boolean('is_packagist')->default(true);
                $table->timestamps();
            },
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
