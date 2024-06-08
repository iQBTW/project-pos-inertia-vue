<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // public function sluggable()
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'name',
    //         ]
    //     ];
    // }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function order_details()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
