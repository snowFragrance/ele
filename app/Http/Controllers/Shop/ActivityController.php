<?php

namespace App\Http\Controllers\Shop;

use App\Models\Activity;
use App\Models\Event;
use App\Models\EventUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivityController extends BaseController
{
    public function index()
    {
        $time = Carbon::now();
        $activities = Activity::all()->where("end_time",">","$time");
        $events = Event::where("end",">","$time")->get();
//        dd($events);
        return view("shop.activity.index",compact("activities",'events'));
    }

    public function xq($id)
    {
        $activity = Activity::find($id);
        return view("shop.activity.xq",compact("activity"));
    }

    public function event($id)
    {
        $event = Event::find($id);
        return view("shop.activity.event",compact("event"));
    }

    public function enroll($id)
    {
        $data['user_id'] =Auth::user()->id;
        $data['event_id'] =$id;
//        dd(EventUser::where('user_id',$data['user_id'])->get());
        if (EventUser::where('user_id',$data['user_id'])->first()){
            return back()->with('danger','只能报名一次哟');
        }
        EventUser::create($data);
        return back()->withInput()->with('success','报名成功');
    }
}
