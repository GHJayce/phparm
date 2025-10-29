<?php

declare(strict_types=1);

namespace GhjayceTest\PhparmEntity\PrefixMethod;

use GhjayceTest\PhparmEntity\Entity\Tiger;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function testNotExists(): void
    {
        $this->expectException(\BadFunctionCallException::class);
        $computer = Tiger::make();
        $computer->setMother('gaga');
    }

    public function testSetNotPublic(): void
    {
        $this->expectException(\BadFunctionCallException::class);
        $computer = Tiger::make();
        $computer->setIucn('LC');
    }

    public function testNotDefine(): void
    {
        $this->expectException(\BadFunctionCallException::class);
        $computer = Tiger::make();
        $computer->cpu();
    }
}