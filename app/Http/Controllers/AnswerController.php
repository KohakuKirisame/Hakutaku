<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

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

}