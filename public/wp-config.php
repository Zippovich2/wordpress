<?php

declare(strict_types=1);

use WordpressWrapper\Loader\Loader;

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new Loader();
$loader->load();

if ('dev' === $_ENV['APP_ENV']) {
    $loader->debugSettings();
}

$table_prefix = $_ENV['DB_TABLE_PREFIX'] ?? 'wp_';

require_once __DIR__ . '/wp/wp-settings.php';
