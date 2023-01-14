<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class AnswerController extends BaseController{

	public function answerWrite(Request $request, $qid){
		$qid=intval($qid);
		$user=$request->user();
		$question=Question::where(["id"=>$qid])->first();
		if(Answer::where(["question"=>$qid,"user"=>$user->id])->exists()){
			$aid=Answer::where(["question"=>$qid,"user"=>$user->id])->first()->id;
			return redirect("/Question/".$qid."/Answer/".$aid."/Edit");
		}
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		$questioner=User::where(["id"=>$question->user])->first();
		$questioner->avatar=UserController::getAvatar($questioner->id);
		return view("answer.edit",["user"=>$user,"question"=>$question,"subjects"=>$subjects,"questioner"=>$questioner]);
	}

	public function answerEdit(Request $request, $qid, $aid){
		$aid=intval($aid);
		$user=$request->user();
		$qid=intval($qid);
		if(!Answer::where(["id"=>$aid])->exists()||Answer::where(["id"=>$aid])->first()->user!=$user->id||Answer::where(["id"=>$aid])->first()->question!=$qid){
			return redirect("/Question/".$qid);
		}
		$content=Answer::where(["id"=>$aid])->first()->content;
		$question=Question::where(["id"=>$qid])->first();
		$subs=Subject::all();
		$subjects=[];
		foreach($subs as $sub){
			$subjects[$sub->id]=["id"=>$sub->id,"subject"=>$sub->subject];
		}
		$questioner=User::where(["id"=>$question->user])->first();
		$questioner->avatar=UserController::getAvatar($questioner->id);
		return view("answer.edit",["user"=>$request->user(),"question"=>$question,"subjects"=>$subjects,"questioner"=>$questioner,"content"=>$content]);
	}

	public function saveAnswer(Request $request, $qid){
		$qid=intval($qid);
		$user=$request->user();
		if(Answer::where(["question"=>$qid,"user"=>$user->id])->exists()){
			Answer::where(["question"=>$qid,"user"=>$user->id])->update(["content"=>$request->input("answer")]);
		}else{
			$ans=new Answer();
			$ans->question=$qid;
			$ans->user=$user->id;
			$ans->content=$request->input("answer");
			$ans->save();
		}

		return redirect("/Question/".$qid);
	}

	public function showAnswer(Request $request, $qid, $aid){
		$qid=intval($qid);
		$aid=intval($aid);
		$user=$request->user();
		if(Auth::check()){
			if($user->role<=0){
				return redirect("/Dashboard");
			}
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
		$answer=Answer::where(["id"=>$aid])->first();
		if($answer->question!=$qid){
			return redirect("/Question");
		}
		$a=User::where(["id"=>$answer->user])->first();
		$answer->avatar=UserController::getAvatar($a->id);
		$answer->name=$a->name;
		$answer->sign=$a->sign;
		$answer->role=$a->role;
		if($answer->sign==""){
			$answer->sign=$a->school;
		}
		return view("answer.single",["user"=>$user,"question"=>$question,"subjects"=>$subjects,"questioner"=>$questioner,"answer"=>$answer]);
	}

}