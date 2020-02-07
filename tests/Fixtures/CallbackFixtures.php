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

namespace App\Tests\Fixtures;

class CallbackFixtures
{
    public const FILTER_TEXT = 'Filter Works!';
    public const ACTION_TEXT = 'Action Works!';

    public static function filter($content)
    {
        return $content . \sprintf('<blockquote id="filter-test-id">%s</blockquote>', self::FILTER_TEXT);
    }

    public static function action(): void
    {
        \printf('<div id="action-test-id">%s</div>', self::ACTION_TEXT);
    }
}
