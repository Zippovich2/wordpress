<?php

use App\WPLoader;

require_once __DIR__ . '/../vendor/autoload.php';

$kernelLoader = new WPLoader();
$kernelLoader->load();

$table_prefix = isset($_ENV['DB_PREFIX']) ? $_ENV['DB_PREFIX'] : 'wp_';

require_once __DIR__ . '/wp/wp-settings.php';