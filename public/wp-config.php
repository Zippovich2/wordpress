<?php

use WordpressWrapper\Loader\Loader;
use WordpressWrapper\Config\Config;

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new Loader();
$loader->load();

if($_ENV['APP_ENV'] === 'dev'){
    $loader->debugSettings();
}

$table_prefix = isset($_ENV['DB_PREFIX']) ? $_ENV['DB_PREFIX'] : 'wp_';

require_once __DIR__ . '/wp/wp-settings.php';
