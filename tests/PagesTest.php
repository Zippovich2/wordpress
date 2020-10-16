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
            'base_uri' => 'http://localhost:8080',
            'timeout' => 10,
            'allow_redirects' => false,
        ]);
    }

    public function tearDown(): void
    {
        $this->httpClient = null;
    }

    /**
     * @dataProvider pageStatusCodeProvider
     */
    public function testStatusCode($page, $expectedStatusCode): void
    {
        $response = $this->httpClient->request('GET', $page);

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
