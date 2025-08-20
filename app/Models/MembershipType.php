<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    use HasFactory;

    protected $primaryKey = 'membership_type_id'; // Make sure this matches exactly
    protected $keyType = 'integer'; // Add this line
    public $incrementing = true; // Add this line

    protected $fillable = [
        'type_name',
        'description',
        'max_books_allowed',
        'start_date',
        'expiry_date',
        'membership_monthly_fee',
        'membership_annual_fee'
    ];

    protected $casts = [
        'start_date' => 'date',
        'expiry_date' => 'date',
        'membership_monthly_fee' => 'decimal:2',
        'membership_annual_fee' => 'decimal:2'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'membership_type_id');
    }
}
