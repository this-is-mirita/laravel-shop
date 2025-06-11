<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;

    protected $fillable = ['slug', 'title', 'thumbnail'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Brand $brand) {
            //Вместо /brand/123 можно сделать /brand/samsung-galaxy-s24-ultra
            //Тут str(...)->slug() — это Laravel-хелпер, который превращает строку в slug.
            $brand->slug = $brand->slug ?? str($brand->title)->slug();
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
