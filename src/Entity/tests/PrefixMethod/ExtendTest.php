<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\PrefixMethod;

use GhjayceTest\Phparm\Entity\Entity\Data;
use GhjayceTest\Phparm\Entity\Entity\TigerOfIucn;
use PHPUnit\Framework\TestCase;

class ExtendTest extends TestCase
{
    public function testProtected(): void
    {
        $tiger = TigerOfIucn::make();
        $this->assertSame('EN', $tiger->getProtIucn());

        $tiger->setProtIucn('LC');
        $this->assertSame('LC', $tiger->getProtIucn());
    }

    public function testNoPrefix(): void
    {
        $tiger = TigerOfIucn::make();
        $val = $tiger->helloWorld();
        $this->assertSame(TigerOfIucn::NO_PREFIX_METHOD_NAME . '_helloWorld', $val);
    }

    public function testOverrideGet(): void
    {
        $tiger = TigerOfIucn::make(Data::manchurianTiger());
        $val = $tiger->getName();
        $this->assertSame(TigerOfIucn::NAME_HIDE_TIPS, $val);
    }
}