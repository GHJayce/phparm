<?php

declare(strict_types=1);

namespace GhjayceTest\PhparmEntity\Attribute;

use GhjayceTest\PhparmEntity\Entity\Tiger;
use PHPUnit\Framework\TestCase;

class AllTest extends TestCase
{
    public function testOnlyAssigned(): void
    {
        $tiger = Tiger::make();
        $tiger->name = 'ManchurianTiger';
        $tiger->age = 2;
        $this->assertSame([
            'name' => 'ManchurianTiger',
            'age' => 2,
        ], $tiger->all());
    }
}
