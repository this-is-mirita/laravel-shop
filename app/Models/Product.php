<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'brand_id',
        'price',
        'thumbnail',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            //Вместо /brand/123 можно сделать /brand/samsung-galaxy-s24-ultra
            //Тут str(...)->slug() — это Laravel-хелпер, который превращает строку в slug.
            $product->slug = $product->slug ?? str($product->title)->slug();
        });
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
