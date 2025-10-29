<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Url;

use Ghjayce\Phparm\Url\Option\QueryOption;
use Ghjayce\Phparm\Url\Query;
use Ghjayce\Phparm\Url\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testSwapBaseUrl(): void
    {
        $url = 'http://username:password@hostname:9090/path?arg=value#anchor';
        $swapUrl = 'https://usn:pasd@www.hostname.com/a/b?author=GHJayce#hash';
        $urlInstance = Url::make($url)
            ->baseSwap($swapUrl);
        $this->assertSame('https://usn:pasd@www.hostname.com/path?arg=value#anchor', (string)$urlInstance);
    }

    public function testSwapBaseUrlWithoutAuth(): void
    {
        $url = 'http://username:password@hostname:9090/path?arg=value#anchor';
        $swapUrl = 'https://www.hostname.com/a/b?author=GHJayce#hash';
        $urlInstance = Url::make($url)
            ->baseSwap($swapUrl);
        $this->assertSame('https://www.hostname.com/path?arg=value#anchor', (string)$urlInstance);
    }

    public function testToStringWithoutQuery(): void
    {
        $url = 'http://username:password@hostname:9090/path#anchor';
        $urlInstance = Url::make($url);
        $this->assertSame($url, (string)$urlInstance);
    }

    public function testToArray(): void
    {
        $url = 'http://username:password@hostname:9090/path?arg=value#anchor';
        $urlInstance = Url::make($url);
        $this->assertSame([
            'scheme' => 'http',
            'host' => 'hostname',
            'port' => 9090,
            'user' => 'username',
            'pass' => 'password',
            'path' => '/path',
            'query' => [
                'arg' => 'value',
            ],
            'fragment' => 'anchor',
        ], $urlInstance->toArray());
    }

    public function testAppendQuery(): void
    {
        $url = 'http://username:password@hostname:9090/path?arg=value#anchor';
        $url = Url::make($url);
        $url->getQuery()
            ->append([
                'author' => 'GHJayce',
            ]);
        $expect = 'http://username:password@hostname:9090/path?arg=value&author=GHJayce#anchor';
        $this->assertSame($expect, (string)$url);
    }

    public function testMergeQueryEncodingRFC3986(): void
    {
        $url = 'http://username:password@hostname:9090/path?arg=value#anchor';
        $url = Url::make($url);
        $url->getQuery()
            ->merge([
                'arg' => 'hello world',
            ]);
        $expect = 'http://username:password@hostname:9090/path?arg=hello%20world#anchor';
        $this->assertSame($expect, (string)$url);

        $url->getQuery()
            ->merge([
                'arg' => 'hello world',
            ], QueryOption::make()->setEncodingType(PHP_QUERY_RFC3986));
        $this->assertSame($expect, (string)$url);
    }

    public function testMergeQueryEncodingRFC1738(): void
    {
        $url = 'http://username:password@hostname:9090/path?arg=value#anchor';
        $url = Url::make($url);
        $url->getQuery()
            ->merge([
                'arg' => 'hello world',
            ], QueryOption::make()->setEncodingType(PHP_QUERY_RFC1738));
        $expect = 'http://username:password@hostname:9090/path?arg=hello+world#anchor';
        $this->assertSame($expect, (string)$url);
    }

    public function testWithRepeatNumberSign(): void
    {
        $url = 'http://hostname.com/path?arg=value#anchor#abc';
        $instance = Url::make($url);
        $this->assertSame([
            'scheme' => 'http',
            'host' => 'hostname.com',
            'path' => '/path',
            'query' => [
                'arg' => 'value',
            ],
            'fragment' => 'anchor#abc',
        ], $instance->toArray());
    }

    public function testMakeWithArray(): void
    {
        $url = [
            'scheme' => 'http',
            'host' => 'hostname.com',
            'path' => '/path',
            'query' => [
                'arg' => 'value',
            ],
            'fragment' => 'anchor#abc',
        ];
        $instance = Url::make($url);
        $this->assertSame($url, $instance->toArray());
        $this->assertEquals(Query::make('arg=value'), $instance->getQuery());
    }
}