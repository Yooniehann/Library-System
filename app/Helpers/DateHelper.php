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

    public static function diffInDaysExact($date)
    {
        $currentDate = self::now();
        $dueDate = Carbon::parse($date);

        // Calculate exact days difference (negative if overdue)
        return $currentDate->diffInDays($dueDate, false) * -1;
    }

    public static function format($date, $format = 'M d, Y h:i A')
    {
        return Carbon::parse($date)->format($format);
    }

    // New method to calculate whole days overdue (rounded up)
    public static function daysOverdue($date)
    {
        $currentDate = self::now();
        $dueDate = Carbon::parse($date);

        if ($dueDate->gte($currentDate)) {
            return 0;
        }

        // Calculate whole days overdue (rounded up)
        $hoursOverdue = $currentDate->diffInHours($dueDate, false) * -1;
        return max(0, ceil($hoursOverdue / 24));
    }
}
