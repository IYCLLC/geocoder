<?php
namespace IYC\Geocoder\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class GeocoderServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/geocoder.php' => config_path('geocoder.php'),
        ], 'config');
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/geocoder.php', 'geocoder');
        $this->app->bind('geocoder', function ($app) {
            return (new Geocoder(new Client))
                ->setApiKey(config('geocoder.key'))
                ->setLanguage(config('geocoder.language'))
                ->setRegion(config('geocoder.region'))
                ->setBounds(config('geocoder.bounds'))
                ->setCountry(config('geocoder.country'));
        });
    }
}