<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_ins';

    protected $fillable = ['product_id', 'quantity', 'supplier', 'received_date', 'invoice_number', 'notes'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
