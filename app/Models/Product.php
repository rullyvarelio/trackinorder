<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'category_id',
        'price',
        'stock',
        'status',
        'image',
    ];

    protected $with = ['category'];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ],
        ];
    }

    public function scopeSearch(Builder $query, $searchTerm)
    {
        $searchTerm = trim($searchTerm);

        return $query->when($searchTerm !== '', function (Builder $query) use ($searchTerm) {
            $query->where('name', 'like', '%'.$searchTerm.'%')
                ->orWhereHas('category', function (Builder $categoryQuery) use ($searchTerm) {
                    $categoryQuery->where('name', 'like', '%'.$searchTerm.'%');
                })
                ->orWhere('status', 'like', '%'.$searchTerm.'%');
        });
    }

    public static function getSalesEntries()
    {
        return self::leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
            ->leftJoin('orders', 'order_product.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['paid', 'completed'])
            ->whereBetween('orders.created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->select(
                'products.*',
                DB::raw('COALESCE(SUM(order_product.quantity), 0) as total_sales'),
                DB::raw('COALESCE(SUM(order_product.subtotal), 0) as monthly_revenue')
            )
            ->groupBy('products.id')
            ->paginate(10);
    }
}
