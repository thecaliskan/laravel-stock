<?php

namespace TheCaliskan\Stock\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelData\Support\DataConfig;
use TheCaliskan\Stock\StockServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'TheCaliskan\\StockData\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->app->when(DataConfig::class)
            ->needs('$config')
            ->give([]);
    }

    protected function getPackageProviders($app)
    {
        return [
            StockServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }
}
