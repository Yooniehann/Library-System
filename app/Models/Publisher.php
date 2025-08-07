<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = [
        'publisher_name',  // Required field
        'address',         // Nullable
        'contact_email',   // Nullable
        'phone'            // Nullable
    ];
}
