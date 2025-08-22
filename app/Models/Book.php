<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_id';

    protected $fillable = [
        'author_id',
        'publisher_id',
        'category_id',
        'title',
        'isbn',
        'publication_year',
        'language',
        'pages',
        'description',
        'cover_image',
        'pricing'
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'pages' => 'integer',
        'pricing' => 'decimal:2'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'book_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'book_id');
    }
    public function isAvailable()
    {
        return $this->inventories()->where('status', 'available')->exists();
    }
}

