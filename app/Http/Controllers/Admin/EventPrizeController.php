<?php

namespace App\Http\Controllers\Admin;

use App\Models\EventPrize;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventPrizeController extends BaseController
{
    public function index()
    {
        $eps = EventPrize::all();
        foreach ($eps as $k=>$ep){
            $eps[$k]['event'] = Event::find($ep->event_id)->title;
            if ($ep->user_id){
                $eps[$k]['user'] = User::find($ep->user_id)->name;
            }
        }
        return view('admin.prize.index',compact('eps'));
    }

    public function add(Request $request)
    {
        //找到所有活动及用户
        $events = Event::all();
        $users = User::all();
        if ($request->isMethod('post')){
            $data = $this->validate($request,[
                "event_id"=>"required",
                "name" => "required",
            ]);
            $data['user_id'] = $request->post('user_id');
            $data['description'] = $request->post('description');
//            dd($request->post());
            EventPrize::create($data);
            return redirect()->route('admin.prize.index')->with('success','添加成功');
        }
//dd($events[0]->id);
        return view('admin.prize.add',compact('events','users'));
    }

    public function edit(Request $request,$id)
    {
        //找到所有活动及用户
        $events = Event::all();
        $users = User::all();
        $ep = EventPrize::find($id);
        if ($request->isMethod('post')){
            $data = $this->validate($request,[
                "event_id"=>"required",
                "name" => "required",
            ]);
            $data['user_id'] = $request->post('user_id');
            $data['description'] = $request->post('description');
//            dd($request->post());
            $ep->update($data);
            return redirect()->route('admin.prize.index')->with('success','添加成功');
        }
        //dd($events[0]->id);
        return view('admin.prize.edit',compact('events','users','ep'));
    }

    public function del($id)
    {
        $ep = EventPrize::findOrFail($id);
        $ep->delete();
        return redirect()->route('admin.prize.index')->with('success','删除成功');
    }
}
