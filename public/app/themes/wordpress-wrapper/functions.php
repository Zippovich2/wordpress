<?php

declare(strict_types=1);

use WordpressWrapper\Config\Config;

$config = new Config($_ENV['PROJECT_ROOT'] . '/config');
$config->load();

if (!function_exists('ww_enqueue_scripts')) {
    function ww_enqueue_scripts()
    {
        $theme_version = wp_get_theme()->get('Version');

        wp_enqueue_style('style', get_stylesheet_uri(), null, $theme_version);
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css', null, $theme_version);
    }

    add_action('wp_enqueue_scripts', 'ww_enqueue_scripts');
}
