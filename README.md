# Address API
A simple laravel package for managing address like prefecture, city, town and postal code.

### Supported Countries
1. Japan

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

## Available APIs & Sample Response
1. Get: your_domain / address_api / jp / {zip_code} / location
```bash
{
  "id": 32105,
  "code": "3580053",
  "pref": "埼玉県",
  "city": "入間市",
  "town": "仏子"
}
```

2. Get: your_domain / address_api / jp / {zip_code} / location_list
```bash
{
  "location": {
    "id": 32105,
    "code": "3580053",
    "pref": "埼玉県",
    "city": "入間市",
    "town": "仏子"
  },
  "list": {
    "prefectures": [
      "三重県",
      "京都府",
      .....
    ],
    "cities": [
      "さいたま市中央区",
      "さいたま市北区",
      .......,
    ],
    "towns": [
      "三ツ木台",
      "上小谷田",
      ......,
    ]
  }
}
```
3. Get: your_domain / address_api / jp / {pref_name} / cities
```bash
[
  "いなべ市",
  "三重郡川越町",
  "三重郡朝日町",
  ......,
]
```
4. Get: your_domain / address_api / jp / {city_name} / towns
```bash
[
  "中島公園",
  "以下に掲載がない場合",
  "伏見",
  ........
]
```

