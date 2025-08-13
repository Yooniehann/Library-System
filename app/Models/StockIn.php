<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $primaryKey = 'stockin_id';

    protected $fillable = [
        'supplier_id',
        'staff_id',
        'stockin_date',
        'total_books',
        'status'
    ];

    protected $casts = [
        'stockin_date' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function details()
    {
        return $this->hasMany(StockInDetail::class, 'stockin_id');
    }
}
