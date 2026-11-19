<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Maintenance mode...
if (file_exists($maintenance = __DIR__.'/main/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoload...
require __DIR__.'/main/vendor/autoload.php';

// Bootstrap app...
$app = require_once __DIR__.'/main/bootstrap/app.php';

// Run Laravel
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
