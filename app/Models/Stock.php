<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = ['product_id', 'quantity', 'type'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function latest()
    {
        return self::orderBy('created_at', 'desc');
    }

    public function scopeSearch(Builder $query, $searchTerm)
    {
        $searchTerm = trim($searchTerm);

        return $query->when($searchTerm !== '', function (Builder $query) use ($searchTerm) {
            $query->WhereHas('product', function (Builder $productQuery) use ($searchTerm) {
                $productQuery->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('slug', 'like', '%' . $searchTerm . '%');
            })
                ->orWhere('quantity', 'like', '%' . $searchTerm . '%')
                ->orWhere('type', 'like', '%' . $searchTerm . '%');
        });
    }
}
