<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',      // Foreign key to users (required)
        'message',      // Notification content (required)
        'type',         // Enum: notification type (required)
        'sent_date',    // Defaults to current timestamp
        'is_read'       // Boolean read status (default false)
    ];
}
