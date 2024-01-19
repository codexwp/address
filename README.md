# Address API
A simple laravel package for managing address like prefecture, city, town and postal code.

### Supported Countries
1. Japan

### Requirements (For Html Integration)
1. jQuery
2. Axios

## Installation
### 1. Using Composer
Run the following commands-

```bash
composer require "codexwp/address"
php artisan cwp:address_install
```

### 2. Manually
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

## Available APIs
```bash
1. your_domain / address_api / jp / {code} / location
2. your_domain / address_api / jp / {code} / location_list
3. your_domain / address_api / jp / prefectures
4. your_domain / address_api / jp / {pref_name} / cities
5. your_domain / address_api / jp / {pref} / {city_name} / towns
6. your_domain / address_api / jp /{pref} / {city} / {town} /code
```
## Usages
### Laravel Service Class
You can use the available methods in your laravel project.
Just call the class and method from your controller.

Path - "/src/Library/JapanAddressService.php"

### Html Integration
1. Copy and include the "src/resources/js/address.js" file in html page.

2. Check the example code in "example/test.html"

