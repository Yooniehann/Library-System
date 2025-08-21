<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $primaryKey = 'inventory_id';
    protected $fillable = ['book_id', 'stockin_detail_id', 'copy_number', 'condition', 'acquisition_date', 'status'];
    protected $casts = ['acquisition_date' => 'date'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($inventory) {
            // Meaningful format: Book ID + Incremental number + Timestamp
            $count = static::where('book_id', $inventory->book_id)->count() + 1;
            $inventory->copy_number = 'BK' . $inventory->book_id . '-' . $count . '-' . substr(time(), -4);
            // Example: BK1-1-8630 (9-11 characters)
        });
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
    public function stockInDetail()
    {
        return $this->belongsTo(StockInDetail::class, 'stockin_detail_id');
    }
    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'inventory_id');
    }
}
