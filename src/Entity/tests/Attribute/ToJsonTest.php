<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\Attribute;

use GhjayceTest\Phparm\Entity\Entity\Tiger;
use PHPUnit\Framework\TestCase;

class ToJsonTest extends TestCase
{
    public function testUnescapedSlashes(): void
    {
        $tiger = Tiger::make();
        $name = '东北虎/华南虎';
        $tiger->name = $name;
        $tiger->age = 2;
        $except = [
            'name' => $name,
            'age' => 2,
        ];
        $this->assertSame(
            json_encode($except, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            $tiger->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }
}