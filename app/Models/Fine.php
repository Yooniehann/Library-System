<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    protected $primaryKey = 'fine_id';

    protected $fillable = [
        'borrow_id',
        'payment_id',
        'fine_type',
        'amount_per_day',
        'description',
        'fine_date',
        'status'
    ];

    protected $casts = [
        'amount_per_day' => 'decimal:2',
        'fine_date' => 'date'
    ];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class, 'borrow_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
