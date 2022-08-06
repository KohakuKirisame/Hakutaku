<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model{
	public $timestamps=false;
	protected $fillable=[
		"subject"
	];

}