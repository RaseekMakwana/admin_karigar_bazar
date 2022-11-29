<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper;

class City extends Model
{
    use HasFactory;

	protected $table = "city_master";

	public static function load_manage_data($request){
        $result_data = City::from('city_master as cm')
								->select(array('cm.city_id', 'cm.city_name', 'sm.state_name'))
								->leftjoin('state_master as sm','sm.state_id', '=', 'cm.state_id')
								->where(['cm.state_id'=>$request['filter_state']])
								->get();
		return $result_data;
	}

	public static function getCityByStateId($state_id){

	}

	public static function remove_record($value){
		City::where(['city_id'=>$value])->delete();
	}


}
