# Address API
A simple laravel package for managing address like prefecture, city, town and postal code for Japan.
And divisions, districts and upazilas for Bangladesh. (jQuery is required for html integration)

### Supported Countries
1. Japan
2. Bangladesh


## Installation
### 1. Using Composer
Run the following commands-

```bash
composer require "codexwp/address"
php artisan cwp:address_install --country={all/jp/bd}
```

### 2. Using Package
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
php artisan cwp:address_install --country={all/jp/bd}
```

## Available APIs
```bash
//Japan
1.  / address_api / jp / {code} / location
2.  / address_api / jp / {code} / location_list
3.  / address_api / jp / prefectures
4.  / address_api / jp / {pref_name} / cities
5.  / address_api / jp / {pref} / {city_name} / towns
6.  / address_api / jp /{pref} / {city} / {town} /code

//Bangladesh
1.  / address_api / bd / divisions
2.  / address_api / bd / {division_name} / districts
3.  / address_api / bd / {division_name} / {district_name} / upazilas
```
## Usages
### Library Service
You can use the available methods in your laravel project.
Just call the class and method from your controller.

JP - "/src/Library/JpAddressService.php"

BD - "/src/Library/BdAddressService.php"

### Html Integration 
Auto update select list(cities) after change of another select input (prefecture).

1. Copy and include the "src/resources/js/address.js" file in html page.

2. Check the example code in "example" folder

