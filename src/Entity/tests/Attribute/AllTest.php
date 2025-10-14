<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\Attribute;

use GhjayceTest\Phparm\Entity\Computer;
use GhjayceTest\Phparm\Entity\Power;
use PHPUnit\Framework\TestCase;

class AllTest extends TestCase
{

    public function testAll(): void
    {
        $attributes = $this->getComputerAttributes();
        $computer = Computer::make();
        $computer->fill($attributes);
        $this->assertSame($attributes + ['power' => null], $computer->all());
    }
}
