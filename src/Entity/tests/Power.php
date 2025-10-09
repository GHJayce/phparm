<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity;

use Ghjayce\Phparm\Entity\Attribute;

class Power extends Attribute
{
    public int $wattage;
    public string $mainBoardInterface;
    public array $cpuInterface;
    public array $gpuInterface;
    public int $diskInterface;
    public array $powerInterface;
    public string $fan;
}
