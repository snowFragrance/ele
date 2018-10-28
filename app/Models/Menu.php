<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ["goods_name","rating","category_id","goods_price","description","month_sales","tips",
                                "goods_img","status","shop_id"
                            ];
}
