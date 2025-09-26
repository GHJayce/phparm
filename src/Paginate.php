<?php

declare(strict_types=1);

namespace GHJayce\Weapons;

/**
 * Class Random
 * @package GHBJayce\Weapon
 */
class Paginate
{
    public static function calcTotalPage(int $rows, int $page = 1, int $perPage = 15, int $firstPageRows = 0): int
    {
        $total = $firstPageRows && $rows && $page > 1 ? $rows - $firstPageRows : $rows;
        return (int) ceil(($total <= 0 ? 0 : $total) / $perPage);
    }

    public static function calcOffset(int $page = 1, int $perPage = 15, int $firstPageRows = 0): int
    {
        if ($firstPageRows) {
            if ($page === 2) {
                return ($page - 1) * $firstPageRows;
            }
            if ($page > 2) {
                return ($page - 2) * $perPage + $firstPageRows;
            }
        }
        return ($page - 1) * $perPage;
    }

    /**
     * 计算分页参数命中的落点分片keys
     * 例如：共有24个数据，分成3个分片（分片0、分片1、分片2），每个分片长度分为10，perPage=3，page=4，落点第0和第1分片
     * @param int $page
     * @param int $perPage
     * @param int $sliceLength 分片长度
     * @return array example: [0,1]
     */
    public static function calcHitSliceKeys(int $page = 1, int $perPage = 15, int $sliceLength = 100): array
    {
        $res = [];
        $end = ((int) ceil($page * $perPage / $sliceLength)) - 1;
        $calc = ($page - 1) * $perPage / $sliceLength;
        if (!is_int($calc)) {
            $start = ((int)ceil($calc)) - 1;
            if ($start !== $end) {
                $res[] = $start;
            }
        }
        $res[] = $end;
        return $res;
    }
}
