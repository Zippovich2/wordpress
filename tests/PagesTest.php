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

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Roman Skoropadskyi <zipo.ckorop@gmail.com>
 */
class PagesTest extends TestCase
{
    /**
     * @var HttpClientInterface|null
     */
    private $httpClient;

    protected function setUp(): void
    {
        $this->httpClient = HttpClient::create([
            'base_uri' => $_ENV['APP_HTTP_HOST'],
            'max_redirects' => 0,
        ]);
    }

    protected function tearDown(): void
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
    public function testStatusCode($page, $expectedStatusCode): void
    {
        $response = $this->httpClient->request('GET', $page);
        $code = $this->createGetRequest($page);

        static::assertEquals($expectedStatusCode, $code);
        static::assertEquals($expectedStatusCode, $response->getStatusCode());
    }

    public function pageStatusCodeProvider()
    {
        return [
            ['/', 200],
            ['/wp/wp-login.php', 200],
            ['/wp/', 301],
            ['/wp/wp-admin/', 302],
        ];
    }
}
