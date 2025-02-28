<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'status', 'token_order'];

    protected $with = ['user'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'subtotal');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $query, $searchTerm)
    {
        $searchTerm = trim($searchTerm); // Remove extra spaces

        return $query->when($searchTerm !== '', function (Builder $query) use ($searchTerm) {
            $query->where('token_order', 'like', '%'.$searchTerm.'%')
                ->orWhereHas('user', function (Builder $categoryQuery) use ($searchTerm) {
                    $categoryQuery->where('name', 'like', '%'.$searchTerm.'%');
                })
                ->orWhere('status', 'like', '%'.$searchTerm.'%');
        });
    }
}
