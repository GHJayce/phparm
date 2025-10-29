<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Url;

use Ghjayce\Phparm\Url\Query;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    public function testToString(): void
    {
        $queryAttr = Query::make([
            'arg' => 'value',
        ]);
        $this->assertSame('arg=value', (string)$queryAttr);
    }

    public function testEmptyArray(): void
    {
        $queryAttr = Query::make([]);
        $this->assertSame('', (string)$queryAttr);
    }

    public function testEmptyString(): void
    {
        $queryAttr = Query::make('');
        $this->assertSame('', (string)$queryAttr);
    }

    public function testEmpty(): void
    {
        $queryAttr = Query::make();
        $this->assertSame('', (string)$queryAttr);
    }

    public function testWithQuestionMarkString(): void
    {
        $instance = Query::make('?arg=value');
        $this->assertSame('arg=value', (string)$instance);
    }

    public function testWithSpaceCharacterString(): void
    {
        $instance = Query::make(' ?arg=value ');
        $this->assertSame('arg=value', (string)$instance);
    }

    public function testParseWithQuestionMark(): void
    {
        $actual = Query::make('?a=b')->parse('?arg=value');
        $this->assertSame(['arg' => 'value'], $actual);
    }

    public function testParseSpaceCharacter(): void
    {
        $actual = Query::make('?a=b')->parse(' ?arg=value ');
        $this->assertSame(['arg' => 'value'], $actual);
    }

    public function testParseEmpty(): void
    {
        $actual = Query::make('?a=b&c=d')->parse();
        $this->assertSame([], $actual);
    }

    public function testParseEmptyString(): void
    {
        $actual = Query::make('?a=b&c=d')->parse('');
        $this->assertSame([], $actual);
    }

    public function testAppend(): void
    {
        $actual = Query::make('?a=b&c=d')
            ->append('e=f&a=aa');
        $this->assertSame('a=b&c=d&e=f&a=aa', (string)$actual);
    }

    public function testMerge(): void
    {
        $actual = Query::make('a=b&c=d')
            ->merge('e=f&a=aa');
        $this->assertSame('a=aa&c=d&e=f', (string)$actual);
    }

    public function testWithQuestionMarkAndNumberSign(): void
    {
        $instance = Query::make('?arg=value#helloworld');
        $this->assertSame('arg=value', (string)$instance);
    }


    public function testWithQuestionMarkAndNumberSignRepeat(): void
    {
        $instance = Query::make('?arg=value#helloworld#123');
        $this->assertSame('arg=value', (string)$instance);
    }

    public function testWithEndAmpersand(): void
    {
        $instance = Query::make('?arg=value&%20#helloworld');
        $this->assertSame('arg=value&%20', (string)$instance);
    }
}