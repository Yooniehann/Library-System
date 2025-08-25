<?php

namespace App\Models;

use App\Models\BookReturn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'book_id', 'inventory.book_id');
    }

    // Get the book through inventory
    public function book()
    {
        return $this->hasOneThrough(
            Book::class,
            Inventory::class,
            'inventory_id', // Foreign key on inventories table
            'book_id',      // Foreign key on books table
            'inventory_id', // Local key on borrows table
            'book_id'       // Local key on inventories table
        );
    }
}
