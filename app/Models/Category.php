<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['name', 'color'];

    /**
     * Get the products for the category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
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
                ->orWhere('slug', 'like', '%'.$searchTerm.'%');
        });
    }
}
