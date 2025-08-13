<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'membership_type_id',
        'fullname',
        'email',
        'password',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'is_kid',
        'membership_start_date',
        'membership_end_date',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'membership_start_date' => 'date',
            'membership_end_date' => 'date',
            'is_kid' => 'boolean',
        ];
    }

    /**
     * Get the membership type associated with the user.
     */
    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class, 'membership_type_id');
    }

    /**
     * Get the borrows for the user.
     */
    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'user_id');
    }

    /**
     * Get the reservations for the user.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'user_id');
    }

    /**
     * Get the payments made by the user.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    /**
     * Check if user has active membership.
     */
    public function hasActiveMembership(): bool
    {
        return $this->status === 'active' &&
               $this->membership_end_date >= now()->toDateString();
    }
}
