<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'name',
        'description',
        'website',
        'status'
    ];

    public function product(){
        return $this->hasMany(Product::class);
    }
}
