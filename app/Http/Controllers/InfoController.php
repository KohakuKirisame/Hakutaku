<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use function Symfony\Component\String\b;

class InfoController extends BaseController{

	public function infoPage(Request $request){
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		if($request->user()->role==2){
			if(Mentor::where("id","=",$request->user()->id)->exists()){
				$i=Mentor::where("id","=",$request->user()->id)->first();
			}else{
				$m=new Mentor();
				$m->id=$request->user()->id;
				$m->save();
				$i=Mentor::where("id","=",$request->user()->id)->first();
			}
			$i->subjects=explode(",",$i->subjects);
		}else{
			$i=0;
		}
		return view("info",["user"=>$request->user(),"subjects"=>$subjects,"i"=>$i]);
	}

	public function updateAvatar(Request $request){
		if(!$request->hasFile("ava")){
			return back();
		}
		$img=Image::make($request->file("ava"));
		$w=$img->width();
		$h=$img->height();
		if($w!=$h){
			if($h<$w){
				$img->heighten(256);
			}elseif($h>$w){
				$img->widen(256);
			}
			$img->crop(256,256);
		}else{
			$img->resize(256,256);
		}
		if(Storage::exists("public/img/avatar/".$request->user()->id.".png")){
			Storage::delete("public/img/avatar/".$request->user()->id.".png");
		}
		Storage::put("public/img/avatar/".$request->user()->id.".png",$img->encode("png"));
		header ("Cache-Control: no-cache, must-revalidate");
		return redirect("/User");
	}

	public function updatePicture(Request $request){
		if(!$request->hasFile("pic")){
			return back();
		}
		$img=Image::make($request->file("pic"));
		$w=$img->width();
		$h=$img->height();
		if($h<$w&&$w>1920){
			$img->widen(1920);
		}elseif($h>$w&&$h>1920){
			$img->heighten(1920);
		}elseif($h==$w&&$h>1920){
			$img->resize(1920,1920);
		}
		if(Storage::exists("public/img/picture/".$request->user()->id.".jpg")){
			Storage::delete("public/img/picture/".$request->user()->id.".jpg");
		}
		Storage::put("public/img/picture/".$request->user()->id.".jpg",$img->encode("jpg"));
		header ("Cache-Control: no-cache, must-revalidate");
		return redirect("/User");
	}

	public function updateInfo(Request $request){
		$data=$request->validate([
			"school"=>["required"],
			"sex"=>["nullable"],
			"email"=>["nullable"],
			"grade"=>["nullable"]

		],[
			"school.required"=>"学校不能为空",
		]);
		$user=Auth::user();
		if($user->role==2){
			$user->school=$data["school"];
		}
		$user->sex=intval($data["sex"]);
		$user->email=$data["email"];
		$user->grade=$data["grade"];
		$user->save();
		$request->session()->regenerate();
		return redirect("/User");
	}

	public function updateMentor(Request $request){
		$subjects=[];
		foreach([0,1,2,3,4,5,6,7,8,9] as $sub){
			if($request->input("s".$sub)=="on"){
				$subjects[]=$sub;
			}
		}
		$subjects=implode(",",$subjects);
		Mentor::where("id","=",$request->user()->id)->update([
			"subjects"=>$subjects,
			"wechat"=>$request->input("wechat"),
			"qq"=>$request->input("qq"),
			"major"=>$request->input("major"),
			"introduction"=>$request->input("introduction")
		]);
		return back();
	}
}