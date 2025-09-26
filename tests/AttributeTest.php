<?php

namespace tests;

use GHJayce\Weapons\Entity\Atr;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{
    public function testAtr(): void
    {
        $instance = Atr::make();
        foreach ($instance as $key => $value) {
            var_dump($key, $value);
        }
        $instance->get('g');
        return;
        $instance->setE('123');
        var_dump($instance->getE());
    }
}