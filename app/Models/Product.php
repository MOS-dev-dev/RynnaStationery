<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'price', 
        'sale_price', 
        'stock', 
        'description', 
        'category_id', 
        'image',
        'brand',
        'sold_count',
        'is_flash_sale',
        'flash_sale_end'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productImports()
    {
        return $this->hasMany(ProductImport::class);
    }
}
