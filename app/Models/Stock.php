<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = ['product_id', 'quantity', 'type'];

    protected $with = ['product'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function latest()
    {
        return self::orderBy('created_at', 'desc');
    }
}
