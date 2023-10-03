<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "slug",
        "price",
        "active"
    ];


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * 一个产品拥有一个折扣。
     */
    public function discount()
    {
        return $this->hasOne(ProductDiscount::class);
    }
}
