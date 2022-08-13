<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Model;

class Question extends Model{
	function __construct(array $attributes = []){
		parent::__construct($attributes);
	}

}