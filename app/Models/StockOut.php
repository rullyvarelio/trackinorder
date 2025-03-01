<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $table = 'stock_outs';

    protected $fillable = ['product_id', 'quantity', 'reason', 'used_date', 'token_order'];
}
