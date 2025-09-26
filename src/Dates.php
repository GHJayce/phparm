<?php

namespace GHJayce\Weapons;

/**
 * Class Dates
 *
 * 注释说明：
 *
 * 时间戳、日期格式参考：
 *   - 2018-12-19
 *   - 2018-12-19 18:51:30
 *   - 1545216707
 *
 * 变量说明：
 * - $datetime 时间戳、日期格式
 * - $previous_time 以前的时间 时间戳、日期格式
 *
 * @package GHBJayce\Weapon
 */
class Dates
{
    const MINUTE = 60;
    const HOUR = 3600;
    const DAY = 86400;
    const WEEK = 604800; // 7 days
    const MONTH = 2592000; // 30 days
    const YEAR = 31536000; // 365 days

    /**
     * 倒计时
     *
     * @param int|string $previous_time
     * @param null|int|string $latest_time 默认：当前时间
     * @return bool|\DateInterval
     */
    public static function duration($previous_time, $latest_time = null)
    {
        $previous_time = new \DateTime(self::toCommonFormat($previous_time));

        $latest_time = new \DateTime(self::toCommonFormat($latest_time));

        $duration = $previous_time->diff($latest_time);

        return $duration;
    }

    /**
     * 判断时间是否是今天
     *
     * @param int|string $datetime
     * @return bool
     */
    public static function isToday($datetime)
    {
        return self::toDateFormat(self::toStamp($datetime)) === self::toDateFormat();
    }

    /**
     * 判断时间是否是昨天
     *
     * @param int|string $datetime
     * @return bool
     */
    public static function isYesterday($datetime)
    {
        return self::toDateFormat(self::toStamp($datetime)) === self::toDateFormat(strtotime('yesterday', $datetime));
    }

    /**
     * 判断时间是否是明天
     *
     * @param int|string $datetime
     * @return bool
     */
    public static function isTomorrow($datetime)
    {
        return self::toDateFormat(self::toStamp($datetime)) === self::toDateFormat(strtotime('tomorrow', $datetime));
    }

    /**
     * 转换成时间戳
     *
     * @param int|string $datetime
     * @return false|int
     */
    public static function toStamp($datetime)
    {
        return is_numeric($datetime) ? (int)$datetime : strtotime($datetime);
    }

    /**
     * 转换成日期格式
     *
     * @param int|null $timestamp 默认：当前时间
     * @return false|string
     */
    public static function toDateFormat($timestamp = null)
    {
        return date('Y-m-d', $timestamp ?: time());
    }

    /**
     * 转换成常见的日期格式
     *
     * @param null $datetime 默认：当前时间
     * @return false|string
     */
    public static function toCommonFormat($datetime = null)
    {
        return empty($datetime) ? date('Y-m-d H:i:s', $datetime) : (is_string($datetime) ? $datetime : date('Y-m-d H:i:s', $datetime));
    }

    /**
     * 转换成容易阅读的时间
     *
     * @param int|string $previous_time
     * @return string
     */
    public static function toReadable($previous_time)
    {
        $duration = abs(time() - self::toStamp($previous_time));
        $tmp = [
            // '年' => self::YEAR,
            '个月' => self::MONTH,
            '天' => self::DAY,
            '小时' => self::HOUR,
            '分钟' => self::MINUTE,
            '秒' => 1,
        ];

        foreach ($tmp as $k => $v) {
            if ($result = ($duration == 0 && $k === '秒') ? 1 : floor($duration / $v)) {
                return ($result > 12 && $k === '个月') ? $previous_time : (($k === '秒') ? '刚刚' : "{$result} {$k}前");
            }
        }
    }
}
