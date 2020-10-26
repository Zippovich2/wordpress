<?php
use WordpressWrapper\Config\Config;

$config = new Config($_ENV['PROJECT_ROOT'] . '/config');
$config->load();

/**
 * Register parent styles.
 */
function enqueue_styles() {
    wp_enqueue_style('parent-styles', get_template_directory_uri() .'/style.css');
}

add_action('wp_enqueue_scripts', 'enqueue_styles');
