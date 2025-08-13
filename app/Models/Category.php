<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'description',
        'created_date'
    ];

    protected $casts = [
        'created_date' => 'date'
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
