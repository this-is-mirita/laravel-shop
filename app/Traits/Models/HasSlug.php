<?php

namespace App\Traits\Models;


use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        //dump('я в trait');
        static::creating(function (Model $item) {
            //Вместо /brand/123 можно сделать /brand/samsung-galaxy-s24-ultra
            //Тут str(...)->slug() — это Laravel-хелпер, который превращает строку в slug.

            // если повторяется то добавлять -1 к слагу
            $item->slug = $item->slug ?? str($item->{self::slugFrom()})
                ->append(microtime(true)) // используем микросекунды
                ->slug();
        });
    }
    public static function slugFrom(): string{
        return 'title';
    }
}
