<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity;

use PHPUnit\Framework\TestCase;

class PrefixMethodTest extends TestCase
{
    public function testPrefixMethodGetSet(): void
    {
        $cpu = 'Intel Core i9 2.8GHz';
        $cpu2 = 'Intel Core i7 2.8GHz';
        $computer = Computer::make();
        $computer->gpu = 'RX560D';
        $computer->setCpu($cpu);
        $this->assertSame($cpu, $computer->cpu);
        $this->assertSame($cpu, $computer->getCpu());
        $computer->setCpu($cpu2);
        $this->assertSame($cpu2, $computer->cpu);
    }

    public function testPrefixMethodNotSupport(): void
    {
        $this->expectException(\BadFunctionCallException::class);
        $computer = Computer::make();
        $computer->cpu();
    }

    public function testPrefixMethodSetNotPublic(): void
    {
        $this->expectException(\BadFunctionCallException::class);
        $computer = Computer::make();
        $computer->setBiosVersion('a');
    }

    public function testPrefixMethodSetNotExists(): void
    {
        $this->expectException(\BadFunctionCallException::class);
        $computer = Computer::make();
        $computer->setpcie('a');
    }

    public function testPrefixMethodGetOverride(): void
    {
        $computer = Computer::make();
        $res = $computer->getAbc();
        $this->assertSame('getAbc', $res);
    }

    public function testPrefixMethodExtend(): void
    {
        $computer = Computer::make();
        $res = $computer->getProtectBiosVersion();
        $this->assertSame(10000, $res);
    }

    public function testEmptyPrefixMethodExtend(): void
    {
        $computer = MicroComputer::make();
        $res = $computer->helloworld();
        $this->assertSame('emptyPrefixMethod_helloworld', $res);
    }
}