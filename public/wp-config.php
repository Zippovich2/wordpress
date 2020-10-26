<?php

declare(strict_types=1);

/*
 * This file is part of the "Wordpress Wrapper" package.
 *
 * (c) Skoropadskyi Roman <zipo.ckorop@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use WordpressWrapper\Loader\Loader;

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new Loader();
$loader->load();

if ('dev' === $_ENV['APP_ENV']) {
    $loader->debugSettings();
}

$table_prefix = \defined('DB_PREFIX') ? \constant('DB_PREFIX') : 'wp_';

require_once __DIR__ . '/wp/wp-settings.php';
