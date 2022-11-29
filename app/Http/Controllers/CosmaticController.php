<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use App\Models\Area;
use App\Models\City;

class CosmaticController extends Controller
{
    public function get_cities_by_state_id(Request $request){
        $input = $request->input();
        $cities_data = City::select('city_id','city_name')
                            ->where('state_id',$input['state_id'])
                            ->orderBy("city_name","asc")
                            ->get();
        return response()->json($cities_data);
    }
    
    public function get_area_by_city_id(Request $request){
        $input = $request->input();
        $area_data = Area::select('area_id','area_name')
                    ->where('city_id',$input['city_id'])
                    ->orderBy("area_name","asc")
                    ->get();
        return response()->json($area_data);
    }

    public function get_category_by_vendor_type_id(Request $request){
        $input = $request->input();
        $category_data = Category::select('category_id','category_name')
                        ->where('vendor_type_id',$input['vendor_type_id'])
                        ->orderBy("category_name","asc")
                        ->get();
        return response()->json($category_data);
    }
    public function get_services_by_category_id(Request $request){
        $input = $request->input();
        $category_data = Service::select('service_id','service_name')
                        ->where('category_id',$input['category_id'])
                        ->orderBy("service_name","asc")
                        ->get();
        return response()->json($category_data);
    }

}
