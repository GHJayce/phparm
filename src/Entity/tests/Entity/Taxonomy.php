<?php

declare(strict_types=1);

namespace GhjayceTest\PhparmEntity\Entity;

use Ghjayce\PhparmEntity\Attribute;

class Taxonomy extends Attribute
{
    public string $domain; // 域
    public string $kingdom; // 界
    public string $phylum; // 门
    public string $class; // 纲
    public string $order; // 目
    public string $family; // 科
    public string $genus; // 属
    public string $species; // 种
}