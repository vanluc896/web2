<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductImage;

class Product extends Model
{
    use SoftDeletes;
    // có thể bỏ qua khai báo $table nếu đặt theo nguyên tắc số nhiều
    protected $table = 'products';

    // có thể bỏ qua khai báo $primaryKey nếu primary key là id
    protected $primaryKey = 'id';

    protected $fillable = [
        'proname',
        'cateid',
        'brandid',
        'slug',
        'price',
        'sold',
        'sale_price',
        'img',
        'thumbnail',
        'status',
        'description'
    ];

    // Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'cateid', 'cateid');
    }

    // Quan hệ với Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandid', 'id');
    }
    public function images()
    {
        //1 product có nhiều ảnh product_images
        return $this->hasMany(ProductImage::class, 'product_id','id');
    }
}
