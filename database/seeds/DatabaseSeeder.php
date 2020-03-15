<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('import:github-repositories');
        Artisan::call('import:packagist-downloads');

        $this->call(PackageSeeder::class);
        $this->call(PackageReleaseSeeder::class);
    }
}
