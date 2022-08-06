<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController{

	public function dashboard(Request $request){
		return view("dashboard",["user"=>$request->user()]);
	}

}