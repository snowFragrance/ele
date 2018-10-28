<?php

namespace App\Http\Controllers\Shop;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends BaseController
{
    public function index()
    {
        $time = Carbon::now();
        $activities = Activity::all()->where("end_time",">","$time");
        return view("shop.activity.index",compact("activities"));
    }

    public function xq($id)
    {
        $activity = Activity::find($id);
        return view("shop.activity.xq",compact("activity"));
    }
}
