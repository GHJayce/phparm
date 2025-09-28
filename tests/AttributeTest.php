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
            var_dump([456456, $key, $value]);
        }
        $instance->b = [1, 2, 3];
        $instance->get('g');
        var_dump([64565, $instance->toArray(), $instance->getA()]);
        return;
        $instance->setE('123');
        var_dump($instance->getE());
    }
}