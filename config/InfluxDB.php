<?php

return [
    'host' => env('INFLUXDB_HOST', 'localhost'),
    'port' => env('INFLUXDB_PORT', 8086),
    'org' => env('INFLUXDB_ORG', ''),
    'bucket' => env('INFLUXDB_BUCKET', ''),
    'token' => env('INFLUXDB_TOKEN', ''),
    'ssl' => env('INFLUXDB_SSL', false),
    'verifySSL' => env('INFLUXDB_VERIFYSSL', false),
];
