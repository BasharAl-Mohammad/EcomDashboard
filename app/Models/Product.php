<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Product extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'name',
        'description',
        'cost_price',
        'price',
        'sale_price',
        'sku','quantity',
        'featured_image',
        'images',
        'category_id',
        'brand_id',
        'status'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
      }
    
    public function brand() {
        return $this->belongsTo(Brand::class);
    }
}
