# Casablanca

[![Latest Version](https://img.shields.io/github/release/wppusher/casablanca.svg?style=flat-square)](https://github.com/thephpleague/:package_name/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/wppusher/casablanca/master.svg?style=flat-square)](https://travis-ci.org/thephpleague/:package_name)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/wppusher/casablanca.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/:package_name/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/wppusher/casablanca.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/:package_name)
[![Total Downloads](https://img.shields.io/packagist/dt/wppusher/casablanca.svg?style=flat-square)](https://packagist.org/packages/league/:package_name)

Casablanca is a framework for building plugins and themes for WordPress.

## Install

Via Composer

``` bash
$ composer require wppusher/casablanca
```

## Usage

```php
class AwesomeWordPressPlugin extends Casablanca
{
    // ...
}

$plugin = new AwesomeWordPressPlugin;

// Bind services to the container
$plugin->bind('AwesomeWordPress\Database', function()
{
    return new AwesomeWordPress\Database($wpdb);
});
```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email [peter@suhm.dk](mailto:peter@suhm.dk) instead of using the issue tracker.

## Credits

- [Peter Suhm](https://github.com/petersuhm)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
