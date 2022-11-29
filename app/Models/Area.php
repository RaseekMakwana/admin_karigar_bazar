<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper;

class Area extends Model
{
    use HasFactory;

	protected $table = "area_master";

	public static function load_manage_data($request){
        $result_data = Area::from('area_master as am')
								->select(array('am.area_id', 'am.area_name', 'cm.city_name', 'sm.state_name'))
								->leftjoin('city_master as cm','cm.city_id', '=', 'am.city_id')
								->leftjoin('state_master as sm','sm.state_id', '=', 'am.state_id')
								->where(array('am.city_id'=>$request['filter_city'], 'am.state_id'=>$request['filter_state']))
								->get();
		return $result_data;
	}

}
