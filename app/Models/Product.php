<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

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
                ->orWhereHas('category', function (Builder $categoryQuery) use ($searchTerm) {
                    $categoryQuery->where('slug', 'like', '%'.$searchTerm.'%');
                })
                ->orWhere('status', 'like', '%'.$searchTerm.'%');
        });
    }
}
