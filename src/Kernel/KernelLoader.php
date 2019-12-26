<?php

namespace App\Kernel;

use Symfony\Component\Dotenv\Dotenv;

class KernelLoader
{
    private $dotenv;

    public function __construct()
    {
        $this->dotenv = new Dotenv();
    }

    public function load(): void
    {
        define('PROJECT_ROOT', dirname($_SERVER['DOCUMENT_ROOT']));
        define('WEB_ROOT', $_SERVER['DOCUMENT_ROOT']);

        $this->dotenv->loadEnv(PROJECT_ROOT . '/.env');

        $envVars = $this->parseEnvFile(PROJECT_ROOT . '/.env');
        $envVars = $this->parseEnvFile(PROJECT_ROOT . '/.env.local', $envVars);

        if(isset($envVars['APP_ENV'])){
            $envVars = $this->parseEnvFile(PROJECT_ROOT . sprintf('/.env.%s', $envVars['APP_ENV']), $envVars);
            $envVars = $this->parseEnvFile(PROJECT_ROOT . sprintf('/.env.%s.local', $envVars['APP_ENV']), $envVars);
        }

        $this->defineConstants($envVars);

        if (!defined('WP_CONTENT_DIR')) define('WP_CONTENT_DIR', WEB_ROOT . $envVars['CONTENT_DIR']);
        if (!defined('WP_CONTENT_URL')) define('WP_CONTENT_URL', $envVars['WP_HOME'] . $envVars['CONTENT_DIR']);
        if (!defined('ABSPATH')) define('ABSPATH', WEB_ROOT . '/wp/');
    }

    private function defineConstants(array $vars): void
    {
        foreach ($vars as $key=>$value)
        {
            if(!defined($key)){
                define($key, $value);
            }
        }
    }

    private function parseEnvFile(string $path, array $oldEnvVars = []): array
    {
        $envVars = $this->dotenv->parse($this->getFileContent($path));

        return array_merge($oldEnvVars, $envVars);
    }

    private function getFileContent(string $path): string
    {
        if(file_exists($path)){
            return file_get_contents($path);
        }

        return '';
    }
}