<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $table = 'stock_ins';

    protected $fillable = ['product_id', 'quantity', 'supplier', 'received_date', 'invoice_number', 'notes'];
}
