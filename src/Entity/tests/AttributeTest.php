<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity;

use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{
    private function getComputerAttributes(): array
    {
        return [
            'cpu' => 'Intel Core i7 2.8GHz',
            'gpu' => 'Intel HD Graphics 630',
            'mainBoard' => 'ASUS B460M PLUS',
            'memoryBank' => [
                'DDR4 2400MHz 8G',
                'DDR4 2400MHz 8G',
            ],
            'hardDisk' => [
                'TOSHIBA',
                'Phison',
            ],
        ];
    }

    private function powerAttributes(): array
    {
        return [
            'wattage' => 500,
            'mainBoardInterface' => '20+4pin',
            'cpuInterface' => ['4+4pin'],
            'gpuInterface' => ['8pin', '6+2pin'],
            'diskInterface' => 4,
            'powerInterface' => ['4pin'],
            'fan' => '12cm',
        ];
    }

    public function testFill(): void
    {
        $attributes = [
            'cpu' => 'Intel Core i7 2.8GHz',
            'biosVersion' => 123,
        ];
        $computer = Computer::make();
        $computer->fill($attributes);
        $except = [
            'cpu' => $attributes['cpu'],
            'power' => null
        ];
        $this->assertSame($except, $computer->all());
    }

    public function testAll(): void
    {
        $attributes = $this->getComputerAttributes();
        $computer = Computer::make();
        $computer->fill($attributes);
        $this->assertSame($attributes + ['power' => null], $computer->all());
    }

    public function testToJson(): void
    {
        $attributes = $this->getComputerAttributes();
        $computer = Computer::make($attributes);
        $powerAttributes = $this->powerAttributes();
        $power = Power::make($powerAttributes);
        $computer->power = $power;
        $this->assertSame(json_encode($attributes + ['power' => $powerAttributes]), $computer->toJson());
    }

    public function testToArray(): void
    {
        $attributes = $this->getComputerAttributes();
        $computer = Computer::make($attributes);
        $powerAttributes = $this->powerAttributes();
        $power = Power::make($powerAttributes);
        $computer->power = $power;
        $this->assertSame($attributes + ['power' => $powerAttributes], $computer->toArray());
    }

    public function testEach(): void
    {
        $attributes = $this->getComputerAttributes();
        $computer = Computer::make($attributes);
        $components = [];
        foreach ($computer as $field => $value) {
            $components[$field] = $value;
        }
        $this->assertSame($components, $computer->toArray());
    }

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
        $this->assertSame('emptyPrefixMethod,helloworld', $res);
    }
}
