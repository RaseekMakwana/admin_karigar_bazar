<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

	protected $table = "user_master";

	public static function getUserByMobile($mobile){
        return User::where("mobile",$mobile)->first();
	}
	/** 
	 * request: array
	*/
		
	public static function getUserByAttribute($where_array){
        return User::where($where_array)->first();
	}

	public static function removeUserByUserId($user_id){
		return User::where('user_id', $user_id)->delete();
	}

	public static function activeDeactiveUserByUserId($user_id){
		$updateData = array(
			"status" => '0' 
		);
		User::where('user_id', $user_id)->update($updateData);
	}

	public static function getAttributesByUserId($attribute, $user_id){
        return User::select($attribute)->where("user_id",$user_id)->first();
    }

	public static function load_manage_data($input){
		$query = User::from('user_master as um');
			$query->select(array('um.user_id','um.name', 'um.mobile', 'um.user_type'));
			$query->where("um.status",$input['filter_status']);
			if(!empty($input['filter_user_type'])){
				$query->where("um.user_type",$input['filter_user_type']);
			} 
		$data =	$query->orderByDesc("created_at")->get();
		return $data;
	}

}
