<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property float|null $sale_price
 * @property int $stock
 * @property string|null $description
 * @property int|null $category_id
 * @property string|null $image
 * @property string|null $brand
 * @property int $sold_count
 * @property bool $is_flash_sale
 * @property string|null $flash_sale_end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductImport[] $productImports
 */
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
