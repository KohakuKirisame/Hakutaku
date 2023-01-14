<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class QuestionController extends BaseController{

	public function questionPage(Request $request, $qid){
		$qid=intval($qid);
		$user=$request->user();
		if($user->role<=0){
			return redirect("/Dashboard");
		}
		if(!Question::where(["id"=>$qid])->exists()){
			return redirect("/");
		}
		$question=Question::where(["id"=>$qid])->first();
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		$questioner=User::where(["id"=>$question->user])->first();
		$questioner->avatar=UserController::getAvatar($questioner->id);
		if($questioner->sign==""){
			$questioner->sign=$questioner->school;
		}
		$answers=Answer::where(["question"=>$qid])->orderBy("updated_at","desc")->paginate(15);
		foreach($answers as $answer){
			$a=User::where(["id"=>$answer->user])->first();
			$answer->avatar=UserController::getAvatar($a->id);
			$answer->name=$a->name;
			$answer->sign=$a->sign;
			$answer->role=$a->role;
			if($answer->sign==""){
				$answer->sign=$a->school;
			}
		}
		return view("question.single",["user"=>$user,"question"=>$question,"subjects"=>$subjects,"questioner"=>$questioner,"answers"=>$answers]);
	}

	public function newPage(Request $request){
		$user=$request->user();
		if($user->role<=0){
			return redirect("/Dashboard");
		}
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		return view("question.edit",["user"=>$user,"subjects"=>$subjects,"edit"=>false]);
	}

	public function editPage(Request $request, $qid){
		$qid=intval($qid);
		if(Question::where(["id"=>$qid])->exists()){
			$question=Question::where(["id"=>$qid])->first();
		}else{
			return redirect("/Question");
		}
		$user=$request->user();
		if($question->user!=$user->id){
			return redirect("/Question");
		}
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		return view("question.edit",["user"=>$user,"subjects"=>$subjects,"question"=>$question,"edit"=>true]);
	}

	public function editQuestion(Request $request){
		$user=$request->user();
		$data=$request->validate([
			"title"=>["required"],
			"content"=>["required"],
			"subject"=>["required"],
			"captcha"=>["required","captcha"],
		],[
			"title.required"=>"标题不能为空",
			"content.required"=>"内容不能为空",
			"subject.required"=>"科目不能为空",
			"captcha.required"=>"请输入验证码",
			"captcha.captcha"=>"验证码错误"
		]);
		$data["subject"]=intval($data["subject"]);
		if($request->has("qid")){
			$question=Question::where(["id"=>intval($request->input("qid"))])->first();
			if($question->user!=$user->id){
				return redirect("/Action/Logout");
			}
		}else{
			$question=new Question();
			$question->user=$user->id;
		}
		$question->title=$data["title"];
		$question->subject=$data["subject"];
		$question->content=$data["content"];
		$question->save();
		$question->refresh();

		if($request->hasFile("image")){
			$img=Image::make($request->file("image"));
			$w=$img->width();
			$h=$img->height();
			if($h<$w&&$w>2560){
				$img->widen(2560);
			}elseif($h>$w&&$h>2560){
				$img->heighten(2560);
			}elseif($h==$w&&$h>2560){
				$img->resize(2560,2560);
			}
			if(Storage::exists("public/img/question/".$question->id.".jpg")){
				Storage::delete("public/img/question/".$question->id.".jpg");
			}
			Storage::put("public/img/question/".$question->id.".jpg",$img->encode("jpg"));
			$question->update_at=date("Y-m-d H:i:s",time());
			$question->save();
		}
		return redirect("/Question/".$question->id);
	}

	static public function searchQuestion(Request $request){
		if($request->has("type")){
			if($request->input("type")=="string"){
				$content=$request->input("content");
				if($request->input("subject")==""){
					$questions=Question::where("title","like","%".$content."%")->orWhere("content","like","%".$content."%")->orderBy("updated_at","desc")->paginate(20);
				}else{
					$subject=intval($request->input("subject"));
					$questions=Question::whereRaw("`subject` = ".$subject." AND (`title` LIKE '%".$content."%' OR `content` LIKE '%".$content."%')")->orderBy("updated_at","desc")->paginate(20);
				}
			}elseif($request->input("type")=="user"){
				$user=$request->user();
				$questions=Question::where(["user"=>$user->id])->orderBy("updated_at","desc")->paginate(10);
			}
		}else{
			$questions=Question::orderBy("updated_at","desc")->paginate(20);
		}
		foreach($questions as $question){
			$question->ansNum=Answer::where(["question"=>$question->id])->count();
		}
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		return view("question.card",["questions"=>$questions,"subjects"=>$subjects]);
	}

	public function listQuestion(Request $request){
		$user=$request->user();
		if($user->role<=0){
			return redirect("/Dashboard");
		}
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		return view("question.list",["user"=>$user,"subjects"=>$subjects]);
	}

	function myQuestion(Request $request){
		$user=$request->user();
		if($user->role<=0){
			return redirect("/Dashboard");
		}
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		return view("question.my",["user"=>$user,"subjects"=>$subjects]);
	}

}