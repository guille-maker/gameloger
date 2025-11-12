<?php

require_once __DIR__ . '/../vendor/autoload.php';

use OpenApi\Generator;

header('Content-Type: application/json');

$openapi = Generator::scan([__DIR__ . '/../app/Http/Controllers']);
file_put_contents(__DIR__ . '/swagger.json', $openapi->toJson());

echo $openapi->toJson();
