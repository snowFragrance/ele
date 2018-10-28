<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
//use Illuminate\Routing\Controller ;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware("auth:admin",[
            "except"=>["login","reg"]
        ]);
    }

}
