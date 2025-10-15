<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\Attribute;

use GhjayceTest\Phparm\Entity\Entity\Data;
use GhjayceTest\Phparm\Entity\Entity\Tiger;
use PHPUnit\Framework\TestCase;

class FillTest extends TestCase
{
    public function testConstructPublicAttr(): void
    {
        $attr = Data::manchurianTiger();
        $tiger = Tiger::make($attr);
        $this->assertSame($attr, $tiger->all());
    }

    public function testConstructWithProtectedAttr(): void
    {
        $attr = Data::manchurianTiger();
        $tiger2 = Tiger::make(array_merge($attr, [
            'iucn' => 'LC',
        ]));
        $this->assertSame($attr, $tiger2->all());
    }

    public function testFillPublicAttr(): void
    {
        $attr = Data::manchurianTiger();
        $tiger = Tiger::make()
            ->fill($attr);
        $this->assertSame($attr, $tiger->all());
    }

    public function testFillWithProtectedAttr(): void
    {
        $attr = Data::manchurianTiger();
        $tiger2 = Tiger::make()
            ->fill(array_merge($attr, [
                'iucn' => 'DD',
            ]));
        $this->assertSame($attr, $tiger2->all());
    }

}
