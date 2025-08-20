<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'staff_id';

    protected $fillable = [
        'fullname',
        'email',
        'password',
        'phone',
        'position',
        'hire_date',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    public function stockIns()
    {
        return $this->hasMany(StockIn::class, 'staff_id');
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'staff_id');
    }

    public function returns()
    {
        return $this->hasMany(BookReturn::class, 'staff_id');
    }
}
