<?php
use Symfony\Component\Dotenv\Dotenv;

$projectRoot = __DIR__;
$webRoot = __DIR__ . '/public';

$dotenv = new Dotenv();
$dotenv->loadEnv($projectRoot . '/.env');

$envData = file_get_contents($projectRoot . '/.env');
$envVars = $dotenv->parse($envData);

if(isset($envVars['APP_ENV'])){
    $envFiles = [
       '.env.local',
        sprintf('.env.%s', $envVars['APP_ENV']),
        sprintf('.env.%s.local', $envVars['APP_ENV']),
    ];

    foreach ($envFiles as $envFile){
        $path = $projectRoot . '/' . $envFile;
        if(file_exists($path)){
            $data = file_get_contents($path);
            $vars = $dotenv->parse($data);
            $envVars = array_merge($envVars, $vars);
        }
    }
}

foreach ($envVars as $var=>$value){
    switch ($value){
        case 'true':
            define($var, TRUE);
            break;
        case 'false':
            define($var, FALSE);
            break;
        default:
            define($var, $value);
            break;
    }
}

$table_prefix = $envVars['DB_PREFIX'] ?: 'wp_';

define('WP_CONTENT_DIR', $webRoot . $envVars['CONTENT_DIR']);
define('WP_CONTENT_URL', $envVars['WP_HOME'] . $envVars['CONTENT_DIR']);
define('PROJECT_ROOT', $projectRoot);

if (!defined('ABSPATH')) {
    define('ABSPATH', $webRoot . '/wp/');
}
