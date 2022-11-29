<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    use HasFactory;

	protected $table = "user_login_log";

	public static function removeUserLoginLogByUserId($user_id){
		return UserLoginLog::where('user_id', $user_id)->delete();
	}

}
