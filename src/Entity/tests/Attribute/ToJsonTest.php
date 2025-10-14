<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\Attribute;

use GhjayceTest\Phparm\Entity\Computer;
use GhjayceTest\Phparm\Entity\Power;
use PHPUnit\Framework\TestCase;

class ToJsonTest extends TestCase
{
    public function testToJson(): void
    {
        $attributes = $this->getComputerAttributes();
        $computer = Computer::make($attributes);
        $powerAttributes = $this->powerAttributes();
        $power = Power::make($powerAttributes);
        $computer->power = $power;
        $this->assertSame(json_encode($attributes + ['power' => $powerAttributes], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $computer->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
