<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_price', 'status', 'token_order'];

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
        $searchTerm = trim($searchTerm);

        return $query->when($searchTerm !== '', function (Builder $query) use ($searchTerm) {
            $query->where('token_order', 'like', '%'.$searchTerm.'%')
                ->orWhereHas('user', function (Builder $categoryQuery) use ($searchTerm) {
                    $categoryQuery->where('name', 'like', '%'.$searchTerm.'%');
                })
                ->orWhere('status', 'like', '%'.$searchTerm.'%');
        });
    }

    public static function latest()
    {
        return self::orderBy('created_at', 'desc');
    }

    public static function totalPaidOrders()
    {
        return self::whereIn('status', ['paid', 'completed'])->count();
    }

    public static function totalOrdersThisMonth()
    {
        return self::whereIn('status', ['paid', 'completed'])
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->count();
    }

    public static function countARPO()
    {
        $totalRevenue = Transaction::sum('total_price');

        // Count both 'paid' and 'completed' orders
        $totalOrders = self::whereIn('status', ['paid', 'completed'])->count();

        return $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2) : 0;
    }
}
