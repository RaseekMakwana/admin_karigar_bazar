<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

	protected $table = "devices";

    public static function removeDeviceByUserId($user_id){
		return Device::where('user_id', $user_id)->delete();
	}

	public static function activeDeactiveDeviceByUserId($user_id){
		$updateData = array(
			"status" => '0' 
		);
		Device::where('user_id', $user_id)->update($updateData);
	}

}
