<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'reservation_id';

    protected $fillable = [
        'user_id',
        'book_id',
        'reservation_date',
        'expiry_date',
        'status',
        'priority_number',
        'notification_sent'
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
        'expiry_date' => 'datetime',
        'notification_sent' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
