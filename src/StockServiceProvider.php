<?php

namespace TheCaliskan\Stock;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TheCaliskan\Stock\Commands\StockCommand;

class StockServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-stock')
            ->hasConfigFile()
            ->hasMigration('create_laravel_stock_table')
            ->hasCommand(StockCommand::class);
    }
}
