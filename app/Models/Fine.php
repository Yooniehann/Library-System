<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Borrow::class,
            'borrow_id', // Foreign key on borrows table
            'user_id',   // Foreign key on users table
            'borrow_id', // Local key on fines table
            'user_id'    // Local key on borrows table
        );
    }

    // Scopes
    public function scopeUnpaid(Builder $query)
    {
        return $query->where('status', 'unpaid');
    }

    public function scopePaid(Builder $query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeWaived(Builder $query)
    {
        return $query->where('status', 'waived');
    }

    public function scopeOverdue(Builder $query)
    {
        return $query->where('fine_type', 'overdue');
    }

    public function scopeLost(Builder $query)
    {
        return $query->where('fine_type', 'lost');
    }

    public function scopeDamage(Builder $query)
    {
        return $query->where('fine_type', 'damage');
    }

    public function scopeForUser(Builder $query, $userId)
    {
        return $query->whereHas('borrow', function($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    // Calculate total amount for this fine
    public function getTotalAmountAttribute()
    {
        if ($this->fine_type !== 'overdue') {
            return $this->amount_per_day;
        }

        // For overdue fines, calculate based on actual days overdue
        $daysOverdue = \App\Helpers\DateHelper::daysOverdue($this->borrow->due_date);
        return $daysOverdue * $this->amount_per_day;
    }

    // Get days overdue for display
    public function getDaysOverdueAttribute()
    {
        if ($this->fine_type !== 'overdue') {
            return 0;
        }

        return \App\Helpers\DateHelper::daysOverdue($this->borrow->due_date);
    }
}
