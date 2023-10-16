<?php

namespace App\Providers;

use App\Services\Faker\Providers\FixtureImageProvider;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider(new FixtureImageProvider($faker));

            return $faker;
        });
    }
}
