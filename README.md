# Address API
A simple laravel package for managing address like prefecture, city, town and postal code.

###Supported Countries
1. Japan

##Installation
###1. Using Composer
Run the following commands-

```bash
composer require "codexwp/address"
php artisan cwp:address_install
```

###2. Manually
At first, create a folder like "packages" in your project. Then you can create 
sub folder like "packages/codexwp/address". Then put "src" folder of this package.

Secondly, update your project composer.json file like the following
```bash
    "autoload": {
        "psr-4": {
            "Cwp\\Address\\" : "packages/codexwp/address/src"
        }
    },
```
Thirdly, open config/app.php file and add the following lines to the provider section

```bash
\Cwp\Address\Providers\AddressProvider::class,
```

Finally, discover and install the package.
```bash
composer dump-autoload
php artisan cwp:address_install
```

##Available APIs

