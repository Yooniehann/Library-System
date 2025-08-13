<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $primaryKey = 'borrow_id';

    protected $fillable = [
        'user_id',
        'inventory_id',
        'staff_id',
        'borrow_date',
        'due_date',
        'renewal_count',
        'status'
    ];

    protected $casts = [
        'borrow_date' => 'datetime',
        'due_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function fine()
    {
        return $this->hasOne(Fine::class, 'borrow_id');
    }

    public function bookReturn()
    {
        return $this->hasOne(BookReturn::class, 'borrow_id');
    }
}
