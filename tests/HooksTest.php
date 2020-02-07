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

use App\Tests\Fixtures\CallbackFixtures;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

final class HooksTest extends TestCase
{
    private const CONFIG_FILES = [
        'filters.yaml',
        'actions.yaml',
    ];

    private $httpClient;

    public function setUp(): void
    {
        foreach (self::CONFIG_FILES as $config) {
            \copy(__DIR__ . \sprintf('/Fixtures/%s', $config), __DIR__ . \sprintf('/../config/%s', $config));
        }

        $this->httpClient = $client = new Client([
            'base_uri' => 'http://localhost:8080',
            'timeout' => 10,
            'allow_redirects' => false,
        ]);
    }

    public function testFilter(): void
    {
        $response = $this->httpClient->request('GET', '/');
        $crawler = new Crawler($response->getBody()->getContents());

        $filterElement = $crawler->filter('#filter-test-id');

        static::assertGreaterThan(0, \count($filterElement));
        static::assertEquals(CallbackFixtures::FILTER_TEXT, $filterElement->eq(0)->text());
    }

    public function testHook(): void
    {
        $response = $this->httpClient->request('GET', '/');
        $crawler = new Crawler($response->getBody()->getContents());

        $actionElement = $crawler->filter('#action-test-id');

        static::assertGreaterThan(0, \count($actionElement));
        static::assertEquals(CallbackFixtures::ACTION_TEXT, $actionElement->eq(0)->text());
    }

    public function tearDown(): void
    {
        foreach (self::CONFIG_FILES as $config) {
            $path = __DIR__ . \sprintf('/../config/%s', $config);

            if (\file_exists($path)) {
                \unlink($path);
            }
        }
    }
}
