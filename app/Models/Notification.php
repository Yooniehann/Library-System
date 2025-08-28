<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;


class Notification extends DatabaseNotification
{
    use HasFactory;

    protected $primaryKey = 'notification_id';

    protected $casts = [
        'sent_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}