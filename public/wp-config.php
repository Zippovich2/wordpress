<?php

use App\Kernel\KernelLoader;

require_once __DIR__ . '/../vendor/autoload.php';

$kernelLoader = new KernelLoader();
$kernelLoader->load();

$table_prefix = isset($_ENV['DB_PREFIX']) ? $_ENV['DB_PREFIX'] : 'wp_';

require_once __DIR__ . '/wp/wp-settings.php';