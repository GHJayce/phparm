<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\Attribute;

use GhjayceTest\Phparm\Entity\Computer;
use GhjayceTest\Phparm\Entity\Power;
use PHPUnit\Framework\TestCase;

class ToArrayTest extends TestCase
{
    public function testToArray(): void
    {
        $attributes = $this->getComputerAttributes();
        $computer = Computer::make($attributes);
        $powerAttributes = $this->powerAttributes();
        $power = Power::make($powerAttributes);
        $computer->power = $power;
        $this->assertSame($attributes + ['power' => $powerAttributes], $computer->toArray());
    }
}
