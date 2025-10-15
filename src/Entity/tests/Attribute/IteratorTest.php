<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\Attribute;

use GhjayceTest\Phparm\Entity\Entity\Tiger;
use PHPUnit\Framework\TestCase;

class IteratorTest extends TestCase
{
    public function testEach(): void
    {
        $tiger = Tiger::make();
        $tiger->name = '华北虎';
        $tiger->age = 3;
        $this->assertSame([
            'name' => '华北虎',
            'age' => 3,
        ], $tiger->all());
    }
}