<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'token_order',
        'total_price',
        'paid',
        'changes',
    ];

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
