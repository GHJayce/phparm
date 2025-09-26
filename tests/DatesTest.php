<?php

namespace tests;

use PHPUnit\Framework\TestCase;

class DatesTest extends TestCase
{
    public function setUp(): void
    {
        date_default_timezone_set('PRC');
    }

    public function testDuration()
    {
        $this->assertEquals([
            'y' => 1,
            'm' => 2,
            'd' => 4,
            'h' => 19,
            'i' => 4,
            's' => 6,
            'f' => 0.0,
            'weekday' => 0,
            'weekday_behavior' => 0,
            'first_last_day_of' => 0,
            'invert' => 0,
            'days' => 430,
            'special_type' => 0,
            'special_amount' => 0,
            'have_weekday_relative' => 0,
            'have_special_relative' => 0,
        ], to_array(date_duration('2017-10-15 20:31:29', '2018-12-20 15:35:35')));
    }

    public function testToReadable()
    {
        $this->assertEquals('刚刚', date_readable(time()));
        $this->assertEquals('1 分钟前', date_readable(strtotime('-1 minute')));
        $this->assertEquals('5 个月前', date_readable(date('Y-m-d', strtotime('-5 month -13 hour'))));
        $this->assertEquals('2016-12-20 18:56:29', date_readable('2016-12-20 18:56:29'));
    }

    public function testToDateFormat()
    {
        $this->assertEquals('2018-12-21', to_date_format(1545358815));
    }

    public function testToCommonFormat()
    {
        $this->assertEquals('2018-12-21 10:20:15', date_common_format(1545358815));
        $this->assertEquals('2018-12-21 10:20:15', date_common_format('2018-12-21 10:20:15'));
    }
}