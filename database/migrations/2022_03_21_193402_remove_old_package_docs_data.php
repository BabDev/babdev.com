<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table): void {
            $table->dropColumn('docs_branches');
            $table->dropColumn('default_docs_version');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table): void {
            $table->json('docs_branches')->nullable();
            $table->string('default_docs_version')->nullable();
        });
    }
};
