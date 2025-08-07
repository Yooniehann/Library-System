<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'user_id',        // Foreign key to users (required)
        'borrow_id',      // Foreign key to borrow records (required)
        'reason',         // Reason for fine (required)
        'amount',         // Decimal amount (required)
        'paid_status',    // Boolean (default false)
        'issued_date',    // Defaults to current date
        'paid_date'       // Nullable until paid
    ];
}
