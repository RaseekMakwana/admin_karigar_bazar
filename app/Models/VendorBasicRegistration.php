<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBasicRegistration extends Model
{
    use HasFactory;

    protected $table = 'vendor_basic_registration';

	protected $timestamp = false;

	public static function getVendorById($user_id){
		return VendorBasicRegistration::where("user_id",$user_id)->first();
	}
	public static function getVendorByMobile($mobile){
		return VendorBasicRegistration::where(["mobile" => $mobile, "status" => '1'])->first();
	}

    public static function load_manage_data($request){

		$query = VendorBasicRegistration::from('vendor_basic_registration');
		$query->select("*");
		if(!empty($request['filter_date'])){
			$query->whereBetween('created_at', [$request['filter_date'].' 00:00:00', $request['filter_date'].' 23:59:59']);
		}
		if(!empty($request['filter_action'])){
			$query->where('status', $request['filter_action']);
		}
		$query->orderBy("created_at","desc");
		return $query->get();
	}

	public static function get_vendor_details($request){
		return VendorBasicRegistration::select("*")
					->where("user_id",$request['user_id'])
					->first();
	}

	public static function vendor_approve($value){
		$updateData = array(
			"status" => '2'
		);
		VendorBasicRegistration::where('user_id', $value)
		->update($updateData);
	}

	public static function vendor_reject($value){
		$updateData = array(
			"status" => '3'
		);
		VendorBasicRegistration::where('user_id', $value)
		->update($updateData);
	}

	public static function vendor_delete($value){
		VendorBasicRegistration::where('user_id',$value)->delete();
	}
}
