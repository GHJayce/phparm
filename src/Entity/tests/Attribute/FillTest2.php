<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\Attribute;

use GhjayceTest\Phparm\Entity\Computer;
use GhjayceTest\Phparm\Entity\Power;
use PHPUnit\Framework\TestCase;

class FillTest2 extends TestCase
{
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
        $this->assertSame(json_encode($attributes + ['power' => $powerAttributes], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $computer->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
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

    private function getComputerAttributes(): array
    {
        return [
            'cpu' => 'Intel Core i7 2.8GHz',
            'gpu' => 'Intel HD Graphics 630',
            'mainBoard' => 'ASUS B460M PLUS / 超大碗',
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
}
