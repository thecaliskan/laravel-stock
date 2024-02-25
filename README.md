# Laravel Stock, Forex, Crypto Data API
[![Latest Version on Packagist](https://img.shields.io/packagist/v/thecaliskan/laravel-stock.svg?style=flat-square)](https://packagist.org/packages/thecaliskan/laravel-stock)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/thecaliskan/laravel-stock/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/thecaliskan/laravel-stock/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/thecaliskan/laravel-stock/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/thecaliskan/laravel-stock/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/thecaliskan/laravel-stock.svg?style=flat-square)](https://packagist.org/packages/thecaliskan/laravel-stock)

This package provides a simple way to get stock data in Laravel apps. **(w/delay)**

Here's a quick example:

```php
use TheCaliskan\Stock\Facades\Stock;

Stock::stock()
Stock::stock('TEAM')
Stock::stock('TEAM', now()->addWeek(-1))

Stock::forex()
Stock::forex('C:USDTRY')
Stock::forex('C:USDTRY')

Stock::crypto()
Stock::crypto('X:BTCUSD')
Stock::crypto('X:BTCUSD', now()->addWeek(-1))

```


## Credits

- [thecaliskan](https://github.com/thecaliskan)
- [All Contributors](../../contributors)

## Disclaimers

All data and information is provided “as is” for informational purposes only, and is not intended for trading purposes or financial, investment, tax, legal, accounting or other advice. Please consult your broker or financial representative to verify pricing before executing any trade. This package is not an investment adviser, financial adviser or a securities broker. None of the data and information constitutes investment advice nor an offering, recommendation or solicitation by this package to buy, sell or hold any security or financial product, and this package makes no representation (and has no opinion) regarding the advisability or suitability of any investment.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
