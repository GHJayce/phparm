<?php

declare(strict_types=1);

namespace GHJayce\Weapons;

/**
 * Class Random
 * @package GHBJayce\Weapon
 */
class Random
{
    public static function uniqueTurn(int $total, int $count, array $range = []): array
    {
        $res = [];
        while ($count > 0) {
            $min = 0;
            $max = $total - 1;
            if ($range) {
                $index = array_rand($range);
                $item = $range[$index];
                unset($range[$index]);
                if (!isset($item[1])) {
                    $count--;
                    $res[] = $item;
                    continue;
                }
                list($min, $max) = $item;
            }
            $output = self::splitRange($min, $max);
            $res[] = $output['number'];
            $count--;
            if ($output['range']) {
                array_push($range, ...$output['range']);
            }
        }
        $range = array_values($range);
        return compact('range', 'res');
    }

    public static function splitRange(int $min, int $max): array
    {
        $number = mt_rand($min, $max);
        $range = [];
        if ($number > $min) {
            $rangeValue = [$min, $number - 1];
            if ($number - 1 === $min) {
                $rangeValue = $min;
            }
            $range[] = $rangeValue;
        }
        if ($number < $max) {
            $rangeValue = [$number + 1, $max];
            if ($number + 1 === $max) {
                $rangeValue = $max;
            }
            $range[] = $rangeValue;
        }
        return compact('number', 'range');
    }

    public static function unique(int $minimum, int $maximum, int $getQuantity, array $range = []): array
    {
        $res = [];
        while ($getQuantity > 0) {
            $min = $minimum;
            $max = $maximum - 1;
            if ($range) {
                $index = array_rand($range);
                $item = $range[$index];
                unset($range[$index]);
                if (!isset($item[1])) {
                    $getQuantity--;
                    $res[] = $item;
                    continue;
                }
                list($min, $max) = $item;
            }
            $output = self::splitRange($min, $max);
            $res[] = $output['number'];
            $getQuantity--;
            if ($output['range']) {
                array_push($range, ...$output['range']);
            }
        }
        $range = array_values($range);
        return compact('range', 'res');
    }
}
