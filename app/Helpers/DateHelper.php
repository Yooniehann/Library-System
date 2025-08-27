<?php

namespace App\Helpers;

use App\Models\SimulationSetting;
use Carbon\Carbon;

class DateHelper
{
    public static function now()
    {
        return SimulationSetting::getCurrentDate();
    }

    public static function isPast($date)
    {
        $currentDate = self::now();
        return Carbon::parse($date)->lt($currentDate);
    }

    public static function diffInDays($date)
    {
        $currentDate = self::now();
        return Carbon::parse($date)->diffInDays($currentDate, false);
    }

    public static function format($date, $format = 'M d, Y h:i A')
    {
        return Carbon::parse($date)->format($format);
    }
}
