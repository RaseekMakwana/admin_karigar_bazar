<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper;

class Service extends Model
{
    use HasFactory;

	protected $table = "service_master";

	public static function load_manage_data($request){
        $result_data = Service::from('service_master as sm')
								->select(array('sm.service_id', 'sm.service_name', 'cm.category_name'))
								->leftjoin('category_master as cm','cm.category_id', '=', 'sm.category_id')
								->where(['sm.category_id'=>$request['filter_category']])
								->get();
		return $result_data;
	}

	public static function getServicesByServiceIds($array){
		return Service::whereIn('service_id', $array)->get();
	}


}
