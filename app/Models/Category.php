<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['title'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Category $category) {
            //Вместо /brand/123 можно сделать /brand/samsung-galaxy-s24-ultra
            //Тут str(...)->slug() — это Laravel-хелпер, который превращает строку в slug.
            $category->slug = $category->slug ?? str($category->title)->slug();
        });
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
