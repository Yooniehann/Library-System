<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    protected $fillable = [
        'book_id',        // Foreign key to books (required)
        'unique_code',    // Unique identifier (required)
        'status',         // Enum: Available/Borrowed/Reserved/Lost/Damaged
        'added_date'      // Date when copy was added
    ];
}
