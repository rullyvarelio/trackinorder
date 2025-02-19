<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
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
        return $this->belongsTo(Categories::class);
    }

    // public function stock()
    // {
    //     return $this->hasOne(Stock::class);
    // }

    // public function stockIn()
    // {
    //     return $this->hasMany(StockIn::class);
    // }

    // public function stockOut()
    // {
    //     return $this->hasMany(StockOut::class);
    // }

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class)->withPivot('quantity', 'subtotal');
    // }



    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }

    public function setStockAttribute($value)
    {
        $this->attributes['stock'] = $value;
        $this->attributes['status'] = $value > 0;
    }
}
