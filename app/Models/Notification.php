<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Carbon\Carbon;

class Notification extends DatabaseNotification
{
    use HasFactory;

    protected $primaryKey = 'notification_id';

    protected $casts = [
        'sent_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Add accessor for is_new attribute
    public function getIsNewAttribute()
    {
        // Consider notifications as "new" if they were sent within the last 5 minutes
        return $this->sent_date->gt(Carbon::now()->subMinutes(5));
    }
}