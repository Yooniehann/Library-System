<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active',
        'simulation_date',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'simulation_date' => 'datetime',
    ];

    public static function getCurrentDate()
    {
        $setting = self::first();

        if ($setting && $setting->is_active && $setting->simulation_date) {
            return $setting->simulation_date;
        }

        return now();
    }

    public static function getSettings()
    {
        return self::firstOrCreate([], [
            'is_active' => false,
            'simulation_date' => now(),
            'description' => 'Default simulation settings'
        ]);
    }
}
