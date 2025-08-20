<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
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
        'role',
        'is_kid',
        'membership_start_date',
        'membership_end_date',
        'status',
        'email_verified_at'
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
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
        'membership_start_date' => 'date',
        'membership_end_date' => 'date',
        'is_kid' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role' => 'Guest',
        'status' => 'active',
        'is_kid' => false,
    ];

    /**
     * Get the membership type associated with the user.
     */
    public function membershipType(): BelongsTo
    {
        return $this->belongsTo(MembershipType::class, 'membership_type_id');
    }

    /**
     * Get the borrows for the user.
     */
    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class, 'user_id');
    }

    /**
     * Get the current active borrows for the user.
     */
    public function activeBorrows(): HasMany
    {
        return $this->borrows()->where('returned_at', null);
    }

    /**
     * Get the reservations for the user.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'user_id');
    }

    /**
     * Get the active reservations for the user.
     */
    public function activeReservations(): HasMany
    {
        return $this->reservations()->where('expires_at', '>', now());
    }

    /**
     * Get the payments made by the user.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    /**
     * Get the successful payments made by the user.
     */
    public function successfulPayments(): HasMany
    {
        return $this->payments()->where('status', 'completed');
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    /**
     * Get the unread notifications for the user.
     */
    public function unreadNotifications(): HasMany
    {
        return $this->notifications()->where('read_at', null);
    }

    /**
     * Check if user has active membership.
     */
    public function hasActiveMembership(): bool
    {
        return $this->status === 'active' &&
               $this->membership_end_date &&
               $this->membership_end_date >= now();
    }

    /**
     * Check if user is a guest (no membership).
     */
    public function isGuest(): bool
    {
        return $this->role === 'Guest';
    }

    /**
     * Check if user is a member.
     */
    public function isMember(): bool
    {
        return $this->role === 'Member';
    }

    /**
     * Check if user is an admin/librarian.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'Librarian';
    }

    /**
     * Check if user is a kid.
     */
    public function isKid(): bool
    {
        return $this->is_kid;
    }

    /**
     * Check if user can borrow more books.
     */
    public function canBorrowMoreBooks(): bool
    {
        if (!$this->membershipType) {
            return false;
        }

        return $this->activeBorrows()->count() < $this->membershipType->max_books_allowed;
    }

    /**
     * Get the remaining books the user can borrow.
     */
    public function remainingBookLimit(): int
    {
        if (!$this->membershipType) {
            return 0;
        }

        return max(0, $this->membershipType->max_books_allowed - $this->activeBorrows()->count());
    }

    /**
     * Activate membership for the user.
     */
    public function activateMembership(int $membershipTypeId, string $duration, int $months = 1): void
    {
        $this->update([
            'membership_type_id' => $membershipTypeId,
            'role' => 'Member',
            'membership_start_date' => now(),
            'membership_end_date' => $duration === 'yearly'
                ? now()->addYear()
                : now()->addMonths($months),
            'status' => 'active'
        ]);
    }
}
