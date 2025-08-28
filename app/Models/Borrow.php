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

    /**
     * Get the return record for this borrow.
     */
    public function returnRecord()
    {
        return $this->hasOne(BookReturn::class, 'borrow_id');
    }

    /**
     * Check if the book is overdue.
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date->isPast() && $this->status === 'active';
    }

    /**
     * Calculate overdue days.
     */
    public function getOverdueDaysAttribute(): int
    {
        if (!$this->due_date->isPast()) {
            return 0;
        }

        return $this->due_date->diffInDays(now());
    }

    /**
     * Calculate fine amount.
     */
    public function getFineAmountAttribute(): float
    {
        if (!$this->due_date->isPast()) {
            return 0;
        }

        return $this->overdue_days * 0.50;
    }

    public function fines()
    {
        return $this->hasMany(Fine::class, 'borrow_id');
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
