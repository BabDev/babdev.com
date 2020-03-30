<?php

use BabDev\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Nova\Nova;
use Laravel\Nova\Console\UserCommand;

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

        $this->call(PackageSeeder::class);
        $this->call(PackageReleaseSeeder::class);

        Artisan::call('import:packagist-downloads');

        Nova::createUserUsing(
            static function (UserCommand $command): array {
                $password = Str::random(20);

                $command->comment(sprintf('Creating account for "michael.babker@gmail.com" with password "%s"', $password));

                return [
                    'Michael Babker',
                    'michael.babker@gmail.com',
                    $password,
                ];
            },
            static function (string $name, string $email, string $password): User {
                $guard = config('nova.guard') ?: config('auth.defaults.guard');

                $provider = config("auth.guards.{$guard}.provider");

                $modelClass = config("auth.providers.{$provider}.model");

                /** @var Builder $builder */
                $builder = $modelClass::query();

                return $builder->create(
                    [
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($password),
                    ]
                );
            }
        );

        Artisan::call('nova:user');

        if (isset($this->command)) {
            $output = Artisan::output();

            $this->command->info(sprintf('%s', substr($output, 0, strpos($output, PHP_EOL))));
        }
    }
}
