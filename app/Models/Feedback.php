<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'user_id',      // Foreign key to users (required)
        'message',      // Feedback content (required)
        'status',       // Enum: Pending/Reviewed (default 'Pending')
        'submitted_at'  // Defaults to current timestamp
    ];
}
