<?php

namespace CodingDelta\InfluxDB;

use InfluxDB2\QueryApi;
use InfluxDB2\WriteApi;
use InfluxDB2\Client;

class InfluxDBClient
{
    private QueryApi $readApi;
    private WriteApi $writeApi;

    public function __construct(Client $client)
    {
        $this->readApi = $client->createQueryApi();
        $this->writeApi = $client->createWriteApi();
    }

    public function read(): QueryApi
    {
        return $this->readApi;
    }

    public function write(): WriteApi
    {
        return $this->writeApi;
    }
}
