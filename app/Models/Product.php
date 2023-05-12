<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'category_id',
        'manufacturer_id',
        'brand_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($product) {
            $product->images()->delete();
        });
    }
}
