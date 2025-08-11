<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',              // Required field
        'isbn',               // Required and unique
        'publication_year',   // Required
        'description',        // Nullable
        'cover_image_url',    // Nullable
        'author_id',          // Foreign key
        'publisher_id',       // Foreign key
        'category_id'         // Foreign key
    ];
    
}

