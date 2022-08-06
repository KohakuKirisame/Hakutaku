<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;

class MentorController extends BaseController{

	public function helpersPage(Request $request){
		if($request->user()->role<=0){
			return redirect("/Dashboard");
		}
		$mentors=Mentor::where("subjects","!=","")->get();
		foreach($mentors as $mentor){
			$m=DB::table("users")->where(["id"=>$mentor->id])->first();
			$mentor->name=$m->name;
			$mentor->school=$m->school;
			$mentor->image=UserController::getImage($mentor->id);
			$mentor->avatar=UserController::getAvatar($mentor->id);
			$mentor->subjects=explode(",",$mentor->subjects);
		}
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		return view("helpers",["user"=>$request->user(),"mentors"=>$mentors,"subjects"=>$subjects]);
	}

	public function detailPage(Request $request, $id){
		$mentor=Mentor::where("id","=",$id)->first();
		$m=DB::table("users")->where(["id"=>$mentor->id])->first();
		$mentor->name=$m->name;
		$mentor->school=$m->school;
		$mentor->sex=intval($m->sex);
		$mentor->image=UserController::getImage($mentor->id);
		$mentor->avatar=UserController::getAvatar($mentor->id);
		if($mentor->subjects!=""){
			$mentor->subjects=explode(",",$mentor->subjects);
		}else{
			$mentor->subjects=["None"];
		}
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		return view("detail",["user"=>$request->user(),"mentor"=>$mentor,"subjects"=>$subjects]);
	}
}