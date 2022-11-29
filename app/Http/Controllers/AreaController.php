<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\State;
use App\Models\City;




class AreaController extends Controller
{
    public function create(){
        $data['state_data'] = State::select('state_id','state_name')->get();
        return view('area.create', compact('data'));
    }
    public function edit($state_id, $city_id){
        $data['state_data'] = State::select('state_id','state_name')->get();
        $data['city_data'] = City::select('city_id','city_name')->where("state_id",$state_id)->get();
        $data['area_data'] = Area::select('area_id','area_name')->where("city_id",$city_id)->get();
        $data['selected_state'] = $state_id;
        $data['selected_city'] = $city_id;
        return view('area.edit', compact('data'));
    }

    public function store(Request $request){
        $input = $request->input();

        if($input['action'] == "create"){
            
            if(!empty($input['area_name'])){
                foreach($input['area_name'] as $key => $value){
                    $insertData = array(
                        "area_id" => uniqid(),
                        "area_name" => $value,
                        "city_id" => $input['city'],
                        "state_id" => $input['state'],
                        "created_date" => date("Y-m-d H:i:s")
                    );
                    Area::insert($insertData);
                }
                return redirect("area/create")->with('success_message', 'Area has been created successfully');
            }
            
        } else if($input['action'] == "edit"){

            if(!empty($input['new_area_name'])){
                foreach($input['new_area_name'] as $key => $value){
                    $insertData = array(
                        "area_id" => uniqid(),
                        "area_name" => $value,
                        "city_id" => $input['city'],
                        "state_id" => $input['state'],
                        "created_date" => date("Y-m-d H:i:s")
                    );
                    Area::insert($insertData);
                }
            }

            if(!empty($input['update_area_name'])){
                foreach($input['update_area_name'] as $key => $value){
                    $updateData = array(
                        "area_name" => $value[0],
                        "city_id" => $input['city'],
                        "state_id" => $input['state']
                    );
                    Area::where('area_id', $key)->update($updateData);
                }
            }
            if(!empty($input['removed_area'])){
                foreach($input['removed_area'] as $key => $value){
                    Area::where(['area_id'=>$value])->delete();
                }
            }

            
            
            return redirect("area/refmanage/".$input['state']."/".$input['city'])->with('success_message', 'Area has been updated successfully');
        }
    }

    public function manage($state_id = null, $city_id = null){
        $data['state_data'] = State::select('state_id','state_name')->get();
        $data['city_data'] = City::select('city_id','city_name')->where("state_id",$state_id)->get();
        $data['selected_state'] = $state_id;
        $data['selected_city'] = $city_id;

        return view('area.manage', compact('data'));
    }
    public function load_manage_data(Request $request){
        $input = $request->input();

		$result = Area::load_manage_data($request);
		$response = array();
		$i = 0;
		if(!empty($result)){
            // p($result);
			foreach($result as $key => $row){
				$response[$i]['no'] = "<input type='checkbox' name='checkbox' class='checkbox' value='".$row->area_id."'>";
				$response[$i]['area_name'] = $row->area_name;
				$response[$i]['city_name'] = $row->city_name;
				$response[$i]['state_name'] = $row->state_name;
				$i++;
			}
		} 
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
    }

    public function delete(Request $request){
        $input = $request->input();
        $expload_values = explode(',',$input['checked_values']);
        foreach($expload_values as $key => $value){
            Area::where(['area_id'=>$value])->delete();
        }
    }

    

    
    
}
