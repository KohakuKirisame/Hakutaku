<?php

namespace App\Http\Controllers;
use App\Models\Mentor;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController{

	static public function getAvatar(int $id=0){
		if($id==0){
			$id=Auth::id();
		}
		if(Storage::exists("public/img/avatar/".$id.".png")){
			return Storage::url("public/img/avatar/".$id.".png");
		}else{
			return("/storage/img/avatar/default.png");
		}
	}

	static public function getImage(int $id=0){
		if($id==0){
			$id=Auth::id();
		}
		if(Storage::exists("public/img/picture/".$id.".jpg")){
			return Storage::url("public/img/picture/".$id.".jpg");
		}else{
			return("/storage/img/picture/default.jpg");
		}
	}

	public function loginPage(){
		if(!Auth::check()){
			return view("login");
		}else{
			return redirect("/Dashboard");
		}
	}

	public function registerPage(){
		if(!Auth::check()){
			return view("register");
		}else{
			return redirect("/Dashboard");
		}
	}

	public function login(Request $request){
		$credentials=$request->validate([
			"phone"=>['required'],
			"password"=>['required'],
		]);

		if(Auth::attempt($credentials,filter_var($request->input("remember"), FILTER_VALIDATE_BOOLEAN))){
			$request->session()->regenerate();
			echo("Success");
		}
	}

	public function register(Request $request){
		$data=$request->validate([
			"name"=>["required"],
			"phone"=>["required","unique:users"],
			"role"=>["required"],
			"school"=>["nullable"],
			"password"=>["required"],
			"captcha"=>["required","captcha"],
		],[
			"name.required"=>"姓名不能为空",
			"phone.required"=>"手机不能为空",
			"phone.unique"=>"手机号已被注册",
			"role.required"=>"请选择身份",
			"password.required"=>"请输入密码",
			"captcha.required"=>"请输入验证码",
			"captcha.captcha"=>"验证码错误"
		]);
		$data["role"]=intval($data["role"]);
		if($data["role"]!=2){
			$data["school"]="北京市第一六一中学";
		}
		$user=new User();
		$user->name=$data["name"];
		$user->phone=$data["phone"];
		$user->role=0-$data["role"];
		$user->school=$data["school"];
		$user->password=Hash::make($data["password"]);
		$user->save();
		return redirect("/Login");
	}

	public function changePass(Request $request){
		$data=$request->validate([
			"curPass"=>["required","current_password"],
			"newPass"=>["required"]
		],[
			"curPass.current_password"=>"当前密码输入错误"
		]);
		$user=Auth::user();
		$user->password=Hash::make($data["newPass"]);
		$user->save();
		return back();
	}

	public function logout(Request $request){
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('/');
	}


}