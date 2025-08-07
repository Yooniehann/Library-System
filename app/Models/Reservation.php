<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',            // Foreign key to users (required)
        'copy_id',            // Foreign key to book copies (required)
        'reservation_date',   // Defaults to current timestamp
        'expiration_date',    // When reservation expires (required)
        'status'              // Enum: Pending/Completed/Canceled
    ];
}
