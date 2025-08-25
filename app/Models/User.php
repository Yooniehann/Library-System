<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
        'membership_start_date' => 'date',
        'membership_end_date' => 'date',
        'is_kid' => 'boolean',
    ];

    protected $attributes = [
        'role' => 'Guest',
        'status' => 'active',
        'is_kid' => false,
    ];

    public function membershipType(): BelongsTo
    {
        return $this->belongsTo(MembershipType::class, 'membership_type_id');
    }

    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class, 'user_id');
    }

    /**
     * Get the current active borrows for the user.
     * FIXED: Using status field instead of returned_at
     */
    public function activeBorrows(): HasMany
    {
        return $this->borrows()->where('status', 'active');
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
     * FIXED: Using status field and expiry_date
     */
    public function activeReservations(): HasMany
    {
        return $this->reservations()
                    ->where('reservations.status', 'pending') // FIXED: Added table prefix
                    ->where('expiry_date', '>', now());
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
     * Get the fines for the user through borrows.
     */
    public function fines(): HasManyThrough
    {
        return $this->hasManyThrough(
            Fine::class,
            Borrow::class,
            'user_id',    // Foreign key on borrows table
            'borrow_id',  // Foreign key on fines table
            'user_id',    // Local key on users table
            'borrow_id'   // Local key on borrows table
        );
    }

    /**
     * Get the unpaid fines for the user.
     * FIXED: Added table prefix to avoid ambiguous column error
     */
    public function unpaidFines(): HasManyThrough
    {
        return $this->fines()->where('fines.status', 'unpaid'); // FIXED: Added fines. prefix
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
     * FIXED: Use correct relationship
     */
    public function canBorrowMoreBooks(): bool
    {
        if (!$this->membershipType) {
            return false;
        }

        $activeBorrowsCount = $this->activeBorrows()->count();
        return $activeBorrowsCount < $this->membershipType->max_books_allowed;
    }

    /**
     * Get the remaining books the user can borrow.
     * FIXED: Use correct relationship
     */
    public function remainingBookLimit(): int
    {
        if (!$this->membershipType) {
            return 0;
        }

        $activeBorrowsCount = $this->activeBorrows()->count();
        return max(0, $this->membershipType->max_books_allowed - $activeBorrowsCount);
    }

    /**
     * Get the total amount of unpaid fines.
     * FIXED: Added table prefix to avoid ambiguous column error
     */
    public function getTotalUnpaidFinesAttribute(): float
    {
        return $this->unpaidFines()->sum('fines.amount_per_day'); // FIXED: Added fines. prefix
    }

    /**
     * Check if user has unpaid fines.
     */
    public function hasUnpaidFines(): bool
    {
        return $this->unpaidFines()->exists();
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
