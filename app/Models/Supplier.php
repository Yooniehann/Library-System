<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'contact_person',
        'phone',
        'email',
        'address',
        'discount_rate'
    ];

    protected $casts = [
        'discount_rate' => 'decimal:2'
    ];

    public function stockIns()
    {
        return $this->hasMany(StockIn::class, 'supplier_id');
    }
}
