<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'stockin_detail_id';

    protected $fillable = [
        'stockin_id',
        'book_id',
        'price_per_unit',
        'condition',
        'remarks',
        'received_quantity'
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function stockIn()
    {
        return $this->belongsTo(StockIn::class, 'stockin_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'stockin_detail_id');
    }
}
