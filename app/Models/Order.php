<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'status', 'token_order'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'subtotal');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
