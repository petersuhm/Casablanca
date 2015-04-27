# Casablanca

[![Latest Version](https://img.shields.io/github/release/wppusher/casablanca.svg?style=flat-square)](https://github.com/thephpleague/:package_name/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/wppusher/casablanca/master.svg?style=flat-square)](https://travis-ci.org/thephpleague/:package_name)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/wppusher/casablanca.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/:package_name/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/wppusher/casablanca.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/:package_name)
[![Total Downloads](https://img.shields.io/packagist/dt/wppusher/casablanca.svg?style=flat-square)](https://packagist.org/packages/league/:package_name)

**NB: WIP**

Casablanca is a framework for building plugins and themes for WordPress.

## Install

Via Composer

``` bash
$ composer require wppusher/casablanca
```

## Usage

### The (IoC) container

```php
class AwesomeWordPressPlugin extends Casablanca
{
    // ...
}

$plugin = new AwesomeWordPressPlugin;

// Bind services to the container:
$plugin->bind('AwesomeWordPress\Database', function()
{
    global $wpdb;

    return new AwesomeWordPress\Database($wpdb);
});

// Returns instance of `AwesomeWordPress\Database:
$db = $plugin->make('AwesomeWordPress\Database');

// Now, let's make a class that depends on `AwesomeWordPress\Database`:
class PostsRepository
{
    private $db;
    public function __construct(AwesomeWordPress\Database $db)
    {
        $this->db = $db;
    }
}

// Will automatically fetch $db from the previous binding we made,
// even if we haven't told Casablanca about PostsRepository, since
// it reflects (recursively) on the constructor:
$repository = $plugin->make('AwesomeWordPress\PostsRepository);
```

## Testing

This library is designed using PhpSpec.

``` bash
$ vendor/bin/phpspec run -f pretty
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
