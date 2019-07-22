# Geocode addresses to coordinates

## Installation

Add lines to composer.json

```bash
"require": {
    ...
    "IYCLLC/geocoder": "*"
},
"repositories":[
    {
        "type": "vcs",
        "url": "git@github.com:IYCLLC/geocoder.git"
    }
],
```
## Laravel installation

Thought the package works fine in non-Laravel projects we included some niceties for our fellow artistans.

In Laravel 5.5 the package will autoregister itself. In older versions of Laravel your must manually installed the service provider and facade.

```php
// config/app.php
'providers' => [
    '...',
    IYC\Geocoder\Providers\GeocoderServiceProvider::class
];
```

```php
// config/app.php
'aliases' => array(
    ...
    'Geocoder' => IYC\Geocoder\Facades\Geocoder::class,
)
```

Next, you must publish the config file :

```bash
php artisan vendor:publish --provider="IYC\Geocoder\GeocoderServiceProvider" --tag="config"
```

## Usage

Here's how you can use the Geocoder.

```php

    $geocoder = new Geocoder();
    $geoCoder->setApiKey(config('geocoder.key'));
    
    try {
        return new Address($this->geoCoder->getCoordinatesForAddress('Zvartnoc'));
    } catch (\Throwable $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 404);
    }
```

You can get the result back in a specific language.

```php
$geocoder
   ->getCoordinatesForAddress('Infinite Loop 1, Cupertino')
   ->setLanguage('it');

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.