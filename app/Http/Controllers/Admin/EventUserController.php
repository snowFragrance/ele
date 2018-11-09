<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventUserController extends BaseController
{
    public function index()
    {
        $eus = EventUser::all();
        $ros = [];
        foreach ($eus as $k => $eu){
            $user = User::find($eu->user_id);
            $event = Event::find($eu->event_id);
            $eus[$k]['user'] = $user;
            $eus[$k]['event'] = $event;
//            dd($eus);
        }
        return view('admin.eventUser.index',compact('eus'));
    }
}
