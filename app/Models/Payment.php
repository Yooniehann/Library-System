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

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime'
    ];

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
}
