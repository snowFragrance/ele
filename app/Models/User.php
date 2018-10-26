<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    //
    protected $fillable=["name","email","password","remember_taken"];

    public function us($id)
    {
//        return $this->hasOne(Shop::class)->where("id","shop_id");
        return DB::table('users')
            ->join('shops', 'users.shop_id', '=', 'shops.id')
            ->select('users.*',"shops.*")
            ->where("users.id","{$id}")
            ->get();
    }
}
