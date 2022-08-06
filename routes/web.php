<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\MentorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class,"showHome"]);
Route::get('Login',[UserController::class,"loginPage"])->name("login");
Route::get('Register',[UserController::class,"registerPage"]);
Route::get("Dashboard",[DashboardController::class,"dashboard"])->middleware("auth");
Route::get("User",[InfoController::class,"infoPage"])->middleware("auth");
Route::get("Helpers",[MentorController::class,"helpersPage"])->middleware("auth");
Route::get("Mentor/{id}",[MentorController::class,"detailPage"])->middleware("auth");

Route::prefix("Action")->group(function (){
	Route::post('/Login',[UserController::class,"login"]);
	Route::get("/Logout",[UserController::class,"logout"])->middleware("auth");
	Route::post("/Register",[UserController::class,"register"]);
	Route::post("/UpdateAvatar",[InfoController::class,"updateAvatar"])->middleware("auth");
	Route::post("/UpdateInfo",[InfoController::class,"updateInfo"])->middleware("auth");
	Route::post("/UpdatePassword",[UserController::class,"changePass"])->middleware("auth");
	Route::post("/UpdateMentor",[InfoController::class,"updateMentor"])->middleware("auth");
	Route::post("/UpdatePicture",[InfoController::class,"updatePicture"])->middleware("auth");
});
