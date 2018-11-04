<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //允许修改的字段
    protected $fillable=[
      'username','password','tel'
    ];
}
