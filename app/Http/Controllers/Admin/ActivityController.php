<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends BaseController
{
    public function index(Request $request)
    {
        $url=$request->query();
//        dd($url);
        $select =$request->get("select");
        $keyword=$request->get("keyword");
        //得到当前时间
        $time = Carbon::now();
        $activities = Activity::orderBy("id","desc");
        if ($keyword !== null){

            $activities->where("title","like","%{$keyword}%");
        }

        //活动进行中
        if ($select == 1){
            $activities->where("end_time",">",$time);
        }

        //活动未开始
        if ($select == 0){
            $activities->where("start_time","<",$time);
        }

        //活动已结束
        if ($select == 2){
            $activities->where("end_time",">",$time);
        }
        $activities=$activities->paginate(10);
//        dd($activities);
        return view("admin.activity.index",compact("activities","url"));
    }

    public function add(Request $request)
    {
        if ($request->isMethod("post")){
            $data = $this->validate($request,[
                "title"=>"required",
                "content" => "required",
                "start_time"=>"required"
            ]);
            $data["end_time"]=$request->post("end_time");
            if ($data["start_time"] > $data["end_time"]){
                return back()->withInput()->with("danger","结束时间不能在开始时间之前");
            }
            Activity::create($data);
            return redirect()->route("admin.activity.index")->with("success","添加成功");
        }
        return view("admin.activity.add");
    }

    public function edit(Request $request,$id)
    {
        //找到一条数据
        $activity = Activity::find($id);

        //判断接方法
        if ($request->isMethod("post")){
            $data = $this->validate($request,[
                "title"=>"required",
                "content" => "required",
                "start_time"=>"required"
            ]);
            $data["end_time"]=$request->post("end_time");
            if ($data["start_time"] > $data["end_time"]){
                return back()->withInput()->with("danger","结束时间不能在开始时间之前");
            }
            $activity->update($data);
            return redirect()->route("admin.activity.index")->with("success","编辑成功");
        }

        //视图渲染
        return view("admin.activity.edit",compact("activity"));
    }

    public function del($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();
        return back()->withInput()->with("success","删除成功");
    }
}
