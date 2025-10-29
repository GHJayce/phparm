<?php

declare(strict_types=1);

namespace GhjayceTest\PhparmEntity\Entity;

class Data
{
    public static function tigerTaxonomy(): array
    {
        return [
            'kingdom' => 'Animalia', // 动物界
            'phylum' => 'Chordata', // 脊索动物门
            'class' => 'Mammalia', // 哺乳纲
            'order' => 'Carnivora', // 食肉目
            'family' => 'Felidae', // 猫科
            'genus' => 'Panthera', // 豹属
            'species' => 'Panthera tigris', // 虎
        ];
    }

    public static function manchurianTiger(): array
    {
        return [
            'name' => 'Manchurian tiger', // 东北虎
            'age' => 5,
        ] + static::tigerTaxonomy();
    }

    public static function southChinaTiger(): array
    {
        return [
            'name' => 'South China Tiger', // 华南虎
            'age' => 6,
        ] + static::tigerTaxonomy();
    }
}