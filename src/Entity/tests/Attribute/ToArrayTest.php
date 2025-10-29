<?php

declare(strict_types=1);

namespace GhjayceTest\PhparmEntity\Attribute;

use GhjayceTest\PhparmEntity\Entity\Data;
use GhjayceTest\PhparmEntity\Entity\Tiger;
use GhjayceTest\PhparmEntity\Entity\Zoo;
use PHPUnit\Framework\TestCase;

class ToArrayTest extends TestCase
{
    public function testToArray(): void
    {
        $tiger1 = Data::manchurianTiger();
        $tiger1['name'] = '阳阳';
        $tiger2 = Data::southChinaTiger();
        $tiger2['name'] = '虎妞';
        $zoo = Zoo::make();
        $zoo->manchurianTiger = Tiger::make($tiger1);
        $zoo->southChinaTiger = Tiger::make($tiger2);
        $this->assertSame([
            'manchurianTiger' => $tiger1,
            'southChinaTiger' => $tiger2,
            'javanTiger' => null,
        ], $zoo->toArray());
    }
}
