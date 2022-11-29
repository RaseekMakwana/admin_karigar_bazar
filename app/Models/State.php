<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

	protected $table = "state_master";

	public static function getState(){
        return State::where("status",'1')->get();
	}

}
