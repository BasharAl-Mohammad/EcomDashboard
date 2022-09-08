<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;

class Category extends Model
{
    use AsSource, Attachable;


    protected $fillable = [
        'name',
        'description',
        'image',
        'parent_id',
        'status'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, $this->parentColumn);
    }

    public function children()
    {
        return $this->hasMany(Category::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
