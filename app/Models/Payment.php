<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'user_id',
        'fine_id',
        'membership_type_id',
        'amount',
        'payment_type',
        'payment_method',
        'payment_date',
        'transaction_id',
        'notes',
        'status'
    ];

    // Add this cast to ensure payment_date is treated as a date
    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fine()
    {
        return $this->belongsTo(Fine::class, 'fine_id');
    }

    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class, 'membership_type_id');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFines($query)
    {
        return $query->where('payment_type', 'fine');
    }

    public function scopeMembershipFees($query)
    {
        return $query->where('payment_type', 'membership_fee');
    }
}
