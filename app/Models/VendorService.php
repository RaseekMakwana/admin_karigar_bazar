<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper;

class VendorService extends Model
{
    use HasFactory;

	protected $table = "vendor_service_master";

	protected $fillable = ['user_id', 'category_id', 'service_id', 'state_id', 'city_id'];
	
	public static function removeVendorServiceByUserId($user_id){
		return VendorService::where('user_id', $user_id)->delete();
	}
	public static function activeDeactiveVendorServiceByUserId($user_id){
		$updateData = array(
			"status" => '0' 
		);
		VendorService::where('user_id', $user_id)->update($updateData);
	}

	public static function getVendorServiceByAttribute($condition){
		return VendorService::from("vendor_service_master as vsm")
					->select("vsm.category_id","vsm.service_id","cm.category_name","vsm.service_id")
					->where($condition)
					->leftJoin("category_master as cm","cm.category_id","=","vsm.category_id")
					->get();
	}

	public static function load_manage_data($request){
        $result_data = VendorBasicRegistration::from('vendor_service_master as vsm')
								->select(array('vsm.user_id', 'cam.category_id', 'cam.category_name', 'vsm.service_id', 'cm.city_name', 'sm.state_name'))
								->leftjoin('category_master as cam','cam.category_id', '=', 'vsm.category_id')
								->leftjoin('city_master as cm','cm.city_id', '=', 'vsm.city_id')
								->leftjoin('state_master as sm','sm.state_id', '=', 'vsm.state_id')
								->where('vsm.user_id',$request['user_id'])
								->get();
		return $result_data;
	}

}
