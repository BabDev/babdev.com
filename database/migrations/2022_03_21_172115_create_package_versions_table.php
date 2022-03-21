<?php

use BabDev\Models\Package;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('package_versions', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Package::class)->constrained();
            $table->string('version');
            $table->string('docs_git_branch')->nullable();
            $table->date('released')->nullable();
            $table->date('end_of_support')->nullable();
            $table->timestamps();
            $table->unique(['package_id', 'version'], 'unique_package_version');
        });

        Artisan::call('db:seed', [
            '--class' => 'PackageVersionMigrationSeeder',
            '--force' => true,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('package_versions');
    }
};
