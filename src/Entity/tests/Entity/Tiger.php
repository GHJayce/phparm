<?php

declare(strict_types=1);

namespace GhjayceTest\Phparm\Entity\Entity;

class Tiger extends Taxonomy
{
    protected string $iucn = 'EN'; // IUCN 红色名录等级

    public string $name;
    public int $age;
}