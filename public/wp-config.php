<?php

use WordpressWrapper\Loader\Loader;
use Zippovich2\Wordpress\Config;

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new Loader();
$loader->load();

$table_prefix = isset($_ENV['DB_PREFIX']) ? $_ENV['DB_PREFIX'] : 'wp_';

require_once __DIR__ . '/wp/wp-settings.php';

$config = new Config(PROJECT_ROOT . '/config');
$config->load();