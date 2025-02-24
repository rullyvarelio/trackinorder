<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function stockIn()
    {
        return $this->hasMany(StockIn::class);
    }

    public function stockOut()
    {
        return $this->hasMany(StockOut::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'subtotal');
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

    public function setStockAttribute($value)
    {
        $this->attributes['stock'] = $value;
        $this->attributes['status'] = $value > 0;
    }
}
