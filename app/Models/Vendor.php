<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Device;
use App\Models\VendorService;

class Vendor extends Model
{
    use HasFactory;

	protected $table = "vendor_master";

	public static function load_manage_data($request){
		if(!empty($request['filter_state']) && empty($request['filter_city'])){
			$result_data = Vendor::from('vendor_master as vm')
			->select(array('vm.user_id','vm.vendor_name', 'vm.mobile', 'vm.area', 'cm.city_name','sm.state_name'))
			->leftjoin('city_master as cm','cm.city_id', '=', 'vm.city_id')
			->leftjoin('state_master as sm','sm.state_id', '=', 'vm.state_id')
			->where('vm.state_id',$request['filter_state'])
			->get();
		} else if(!empty($request['filter_state']) && !empty($request['filter_city'])){
			$result_data = Vendor::from('vendor_master as vm')
			->select(array('vm.user_id','vm.vendor_name', 'vm.mobile', 'vm.area', 'cm.city_name','sm.state_name'))
			->leftjoin('city_master as cm','cm.city_id', '=', 'vm.city_id')
			->leftjoin('state_master as sm','sm.state_id', '=', 'vm.state_id')
			->where(['vm.state_id'=>$request['filter_state'], "vm.city_id" => $request['filter_city']])
			->get();
		} else {
			$result_data = Vendor::from('vendor_master as vm')
			->select(array('vm.user_id','vm.vendor_name', 'vm.mobile', 'vm.area', 'cm.city_name','sm.state_name'))
			->leftjoin('city_master as cm','cm.city_id', '=', 'vm.city_id')
			->leftjoin('state_master as sm','sm.state_id', '=', 'vm.state_id')
			->limit(100)
			->orderBy("vm.created_at", "desc")
			->get();
		}
        

		return $result_data;
	}

	public static function removeVendorByUserId($user_id){
		return Vendor::where('user_id', $user_id)->delete();
	}
	
	public static function getVendorByAttribute($array){
		return Vendor::from("vendor_master as vm")
					->select("vm.business_name","cm.city_name","sm.state_name")
					->where($array)
					->leftJoin("city_master as cm","cm.city_id","=","vm.city_id")
					->leftJoin("state_master as sm","sm.state_id","=","vm.state_id")
					->first();
	}

	public static function activeDeactiveVendorByUserId($user_id){
		$updateData = array(
			"status" => '0' 
		);
		Vendor::where('user_id', $user_id)->update($updateData);
	}

}
