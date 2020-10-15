<?php
use WordpressWrapper\Config\Config;

$config = new Config($_ENV['PROJECT_ROOT'] . '/config');
$config->load();