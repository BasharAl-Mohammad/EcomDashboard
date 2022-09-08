<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'name',
        'description',
        'cost_price',
        'price',
        'sale_price',
        'sku',
        'quantity',
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
