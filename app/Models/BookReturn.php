<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowReturn extends Model
{
    use HasFactory;

    protected $primaryKey = 'return_id';

    protected $fillable = [
        'borrow_id',
        'staff_id',
        'return_date',
        'condition_on_return',
        'late_days',
        'fine_amount'
    ];

    protected $casts = [
        'return_date' => 'datetime',
        'fine_amount' => 'decimal:2'
    ];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class, 'borrow_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
