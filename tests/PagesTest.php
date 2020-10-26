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

namespace App\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * @author Roman Skoropadskyi <zipo.ckorop@gmail.com>
 */
class PagesTest extends TestCase
{
    private $httpClient;

    public function setUp(): void
    {
        $this->httpClient = new Client([
            'base_uri' => $_ENV['APP_HTTP_HOST'],
            'timeout' => 10,
            'allow_redirects' => false,
        ]);
    }

    public function tearDown(): void
    {
        $this->httpClient = null;
    }

    private function createGetRequest(string $path): int
    {
        $ch = \curl_init();
        \curl_setopt($ch, CURLOPT_URL, $_ENV['APP_HTTP_HOST'] . $path);
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        \curl_exec($ch);
        $responseCode = \curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        \curl_close($ch);

        return $responseCode;
    }

    /**
     * @dataProvider pageStatusCodeProvider
     */
    public function testStatusCode($page, $expectedStatusCode, $expectedLocation): void
    {
        $response = $this->httpClient->request('GET', $page);
        $code = $this->createGetRequest($page);
        $location = $response->getHeaderLine('Location');

        static::assertEquals($expectedStatusCode, $response->getStatusCode());
        static::assertEquals($expectedStatusCode, $code);
        static::assertEquals($expectedLocation, $location);
    }

    public function pageStatusCodeProvider()
    {
        return [
            ['/', 200, ''],
            ['/wp/wp-login.php', 200, ''],
            ['/wp/', 301,  $_ENV['APP_HTTP_HOST'] . '/wp/wp-admin/'],
            ['/wp/wp-admin/', 302, $_ENV['APP_HTTP_HOST'] . '/wp/wp-login.php?redirect_to=http%3A%2F%2Flocalhost%3A8080%2Fwp%2Fwp-admin%2F&reauth=1'],
        ];
    }
}
