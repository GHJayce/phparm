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
}