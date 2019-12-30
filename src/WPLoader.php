<?php

namespace App;

use Symfony\Component\Dotenv\Dotenv;

class WPLoader
{
    private $dotenv;

    public function __construct()
    {
        $this->dotenv = new Dotenv();
    }

    public function load(): void
    {
        $this->defineConstant('PROJECT_ROOT', dirname($_SERVER['DOCUMENT_ROOT']));
        $this->defineConstant('WEB_ROOT', $_SERVER['DOCUMENT_ROOT']);

        $this->dotenv->loadEnv(PROJECT_ROOT . '/.env');

        $envVars = $this->parseEnvFile(PROJECT_ROOT . '/.env');
        $envVars = $this->parseEnvFile(PROJECT_ROOT . '/.env.local', $envVars);

        if(isset($envVars['APP_ENV'])){
            $envVars = $this->parseEnvFile(PROJECT_ROOT . sprintf('/.env.%s', $envVars['APP_ENV']), $envVars);
            $envVars = $this->parseEnvFile(PROJECT_ROOT . sprintf('/.env.%s.local', $envVars['APP_ENV']), $envVars);
        }

        $this->defineConstants($envVars);

        $this->defineConstant('WP_CONTENT_DIR', WEB_ROOT . $envVars['CONTENT_DIR']);
        $this->defineConstant('WP_CONTENT_URL', $envVars['WP_HOME'] . $envVars['CONTENT_DIR']);
        $this->defineConstant('ABSPATH', WEB_ROOT . '/wp/');

        $this->logSettings();
    }

    private function logSettings(): void
    {
        $this->defineConstant('WP_DEBUG_DIR', PROJECT_ROOT . '/var/log');
        $this->defineConstant('WP_DEBUG_LOG', WP_DEBUG_DIR . sprintf('/%s.log', APP_ENV));

        if(!file_exists(WP_DEBUG_DIR)){
            mkdir(WP_DEBUG_DIR);
        }
    }

    private function defineConstants(array $vars): void
    {
        foreach ($vars as $key=>$value)
        {
            $this->defineConstant($key, $value);
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

    private function defineConstant(string $key, $value): void
    {
        if(!defined($key)){
            define($key, $value);
        }
    }
}