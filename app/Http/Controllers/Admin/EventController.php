<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventPrize;
use App\Models\EventUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends BaseController
{
    public function index()
    {
        $events = Event::all();
//        $date = now();
//        dd($date);
        return view('admin.event.index',compact('events'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            $data = $this->validate($request,[
                "title"=>"required",
                "content" => "required",
                "start"=>"required",
                "prize"=>"required"
            ]);
            $data["end"]=$request->post("end");
            if ($data["start"] > $data["end"]){
                return back()->withInput()->with("danger","结束时间不能在开始时间之前");
            }
            if ($data["prize"] < $data["end"]){
                return back()->withInput()->with("danger","开奖时间不能在结束报名之前");
            }
            $data["is_prize"]=$request->post("is_prize");
            $data["num"]=$request->post("num");
            Event::create($data);
            return redirect()->route("admin.event.index")->with("success","添加成功");
        }
        return view('admin.event.add');
    }

    public function edit(Request $request,$id)
    {
        $event = Event::find($id);
        if ($request->isMethod('post')){
            $data = $this->validate($request,[
                "title"=>"required",
                "content" => "required",
                "start"=>"required",
                "prize"=>"required"
            ]);
            $data["end"]=$request->post("end");
            if ($data["start"] > $data["end"]){
                return back()->withInput()->with("danger","结束时间不能在开始时间之前");
            }
            if ($data["prize"] < $data["end"]){
                return back()->withInput()->with("danger","开奖时间不能在结束报名之前");
            }
            $data["is_prize"]=$request->post("is_prize");
            $data["num"]=$request->post("num");
            $event->update($data);
            return redirect()->route("admin.event.index")->with("success","修改成功");
        }
        return view('admin.event.edit',compact('event'));
    }

    public function del($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route("admin.event.index")->with("success","删除成功");
    }

    public function lottery(Request $request,$id)
    {
//        dd($id);
        /**
         * 按报名活动，找出所有报名此活动用户
         * 找到相匹配的活动奖品 id == event_prize->event_id
         * 将用户打乱放入奖品 user_id 中
         * 将中奖用户邮箱找出来，发放邮件
         */
        $users = EventUser::where('event_id',$id)->get();
        $user_id = [];
        $eps = EventPrize::where('event_id',$id)->get();
        foreach ($eps as $ep){
            foreach ($users as $user){
                $user_id[] = $user->user_id;
                shuffle($user_id);
                foreach ($user_id as $id){
                    $ep->user_id = $id;
                    $ep->save();
                }
            }
        }

        foreach ($eps as $k=>$ep){
            $event = Event::find($ep->event_id);
            $event->is_prize --;
            $event->save();
            $user_id = $ep->user_id;
            $name = EventPrize::where('user_id',$user_id)->first()->name;
            $user = User::find($user_id)->email;
            $shopName=$name;
            $to = "{$user}";//收件人
            $subject = "中奖通知";//邮件标题
            \Illuminate\Support\Facades\Mail::send(
                'emails.event',//视图
                compact("shopName"),//传递给视图的参数
                function ($message) use($to, $subject) {
                    $message->to($to)->subject($subject);
                }
            );
        }

//        exit;
        return redirect()->route("admin.event.index")->with("success","抽奖成功");
    }
}
