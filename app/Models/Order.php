<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ["total","user_id","shop_id","order_code","address","tel","name","status",
        "provence","city","area"];

    static public $statusText=[-1 => "已取消", 0 => "代付款", 1 => "待发货", 2 => "待确认", 3 => "完成"];

    public function getOrderStatusAttribute()
    {
        return self::$statusText[$this->status];//-1 0 1 2 3
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, "shop_id");
    }

    public function goods()
    {
        return $this->hasMany(OrderDetail::class, "order_id");
    }
}
