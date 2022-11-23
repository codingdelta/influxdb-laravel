<?php

namespace CodingDelta\InfluxDB\Facades;

use CodingDelta\InfluxDB\InfluxDBClient;
use Illuminate\Support\Facades\Facade as LaravelFacade;

class InfluxDB extends LaravelFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return InfluxDBClient::class;
    }
}
