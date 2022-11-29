<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\City;
use App\Models\State;


class CityController extends Controller
{
    public function create(){
        // $data['state_data'] = DB::Table('table_name')->select('column1','column2')->where('id',1)->get();
        $data['state_data'] = State::select('state_id','state_name')->get();
        return view('city.create', compact('data'));
    }
    public function edit($id){
        // $data['state_data'] = DB::Table('table_name')->select('column1','column2')->where('id',1)->get();
        $data['state_data'] = State::select('state_id','state_name')->get();
        $data['edit_details'] = City::select('city_id','city_slug','city_name','state_id')->where(['city_id' => $id])->first();
        return view('city.edit', compact('data'));
    }

    public function store(Request $request){
        $input = $request->input();

        if($input['action'] == "create"){
            foreach($input['city_name'] as $key => $value){
                $insertData = array(
                    "city_id" => uniqid(),
                    "city_slug" => Helper::createUrlSlug($value),
                    "city_name" => $value,
                    "state_id" => $input['state'],
                    "country_id" => '1',
                    "created_date" => date("Y-m-d H:i:s")
                );
                City::insert($insertData);
            }
            return redirect("city/manage")->with('success_message', 'City has been created successfully');
        } 

        if($input['action'] == "edit") {
            $updateData = array(
                "city_slug" => Helper::createUrlSlug($input['city_name']),
                "city_name" => $input['city_name'],
                "state_id" => $input['state']
            );
            City::where('city_id', $request["city_id"])
            ->update($updateData);
            return redirect("city/manage")->with('success_message', 'City has been updated successfully');
        }
    }

    public function manage(){
        $data['state_data'] = State::select('state_id','state_name')->get();
        return view('city.manage', compact('data'));
    }
    public function load_manage_data(Request $request){
        $input = $request->input();

        $result = City::load_manage_data($request);
		$response = array();
		$i = 0;
		if(!empty($result)){
            // p($result);
			foreach($result as $key => $row){
				$response[$i]['no'] = "<input type='checkbox' name='checkbox' class='checkbox_2 checkbox' value='".$row->city_id."'>";
				$response[$i]['city_name'] = $row->city_name;
				$response[$i]['state_name'] = $row->state_name;
				$response[$i]['action'] = "<a href='".url('city/edit/'.$row->city_id)."'>Edit</a> | <a href='".url('area/refmanage/'.$input['filter_state'].'/'.$row->city_id)."'>Area</a>";
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
            City::remove_record($value);
        }
    }

    

    
    
}
