<?php

namespace CodingDelta\InfluxDB\Providers;

use CodingDelta\InfluxDB\Facades\InfluxDB;
use CodingDelta\InfluxDB\InfluxDBClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use InfluxDB2\Client;
use InfluxDB2\DefaultApi;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\QueryApi;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/InfluxDB.php' => config_path('influxdb.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(InfluxDBClient::class, function ($app) {
            // $curlOptions = [
            //     CURLOPT_CONNECTTIMEOUT => 30, // The number of seconds to wait while trying to connect.
            // ];

            // $curlClient = new \Http\Client\Curl\Client(
            //     \Http\Discovery\Psr17FactoryDiscovery::findResponseFactory(),
            //     \Http\Discovery\Psr17FactoryDiscovery::findStreamFactory(),
            //     $curlOptions
            // );

            $curlClient = new \GuzzleHttp\Client([
                "request.options" => [
                    'headers' => [
                        'Content-Type' => 'application/vnd.flux'
                    ]
                ]
            ]);

            $client = new Client([
                "url" => "http://" . config('influxdb.host') . ":" . config('influxdb.port'),
                "token" => config('influxdb.token'),
                "bucket" => config('influxdb.bucket'),
                "org" => config('influxdb.org'),
                "precision" => WritePrecision::NS,
                "httpClient" => $curlClient
            ]);

            return new InfluxDBClient($client);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            InfluxDB::class,
        ];
    }
}
