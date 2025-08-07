<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowRecord extends Model
{
    protected $fillable = [
        'user_id',        // Foreign key to users (required)
        'copy_id',        // Foreign key to book copies (required)
        'borrow_date',    // Defaults to current date
        'due_date',       // Required return date
        'return_date',    // Nullable until returned
        'status'          // Enum: Borrowed/Returned/Overdue/Lost/Damaged
    ];
}
