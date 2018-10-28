<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shop extends Model
{
    protected $fillable = ["shop_category_id","shop_name","shop_img","start_send","send_cost","notice","discount",
    "shop_img","brand","on_time","fengniao","bao","piao","zhun","status",'user_id'];

    public function ss()
    {
//        return $this->hasOne(Shop::class)->where("id","shop_id");
        return DB::table('shops')
            ->join('shopcategories as sc', 'shops.shop_category_id', '=', 'sc.id')
            ->select('shops.*',"sc.name")
//            ->where("users.id","{$id}")
            ->get();
    }

    public function su()
    {
        return $this->belongsTo(User::class)->where("user_id","id");
//        return DB::table('shops')
//            ->join('users', 'users.shop_id', '=', 'shops.id')
//            ->select('users.*',"shops.*")
//            ->get();
    }
}
