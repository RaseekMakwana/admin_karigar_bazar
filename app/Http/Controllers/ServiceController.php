<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Service;
use App\Models\VendorType;
use App\Models\Category;


class ServiceController extends Controller
{
    public function create(){
        $data['category_data'] = Category::select('category_id','category_name')->get();
        return view('service.create', compact('data'));
    }
    public function edit($service_ids){
        $explode_ids = explode(",", $service_ids);
        $data['service_data'] = Service::getServicesByServiceIds($explode_ids);
        return view('service.edit', compact('data'));
    }

    public function store(Request $request){
        $input = $request->input();
            
        if(!empty($input['service_name'])){
            foreach($input['service_name'] as $key => $value){
                $insertData = array(
                    "service_id" => uniqid(),
                    "service_slug" => Helper::createUrlSlug($value),
                    "service_name" => $value,
                    "category_id" => $input['category'],
                );
                Service::insert($insertData);
            }
            return redirect("service/manage")->with('success_message', 'Service has been created successfully');
        }
    }

    public function update(Request $request){
        $input = $request->input();
        if(!empty($input['new_service_name'])){
            foreach($input['new_service_name'] as $key => $value){
                $insertData = array(
                    "service_id" => uniqid(),
                    "service_slug" => Helper::createUrlSlug($value),
                    "service_name" => $value,
                );
                Service::insert($insertData);
            }
        }

        if(!empty($input['update_service_name'])){
            foreach($input['update_service_name'] as $key => $value){
                $updateData = array(
                    "service_slug" => Helper::createUrlSlug($value),
                    "service_name" => $value,
                    
                );
                Service::where('service_id', $key)->update($updateData);
            }
        }
        if(!empty($input['removed_service'])){
            foreach($input['removed_service'] as $key => $value){
                Service::where(['service_id'=>$value])->delete();
            }
        }
        return redirect("service/manage")->with('success_message', 'Service has been updated successfully');
    }

    public function manage(){
        $data['category_data'] = Category::select('category_id','category_name')->get();
        return view('service.manage', compact('data'));
    }
    public function load_manage_data(Request $request){
        $input = $request->input();

		$result = Service::load_manage_data($input);
		$response = array();
		$i = 0;
		if(!empty($result)){
            // p($result);
			foreach($result as $key => $row){
				$response[$i]['no'] = "<input type='checkbox' name='checkbox' class='checkbox_2 checkbox' value='".$row->service_id."'>";
				$response[$i]['service_name'] = $row->service_name;
				$response[$i]['category_name'] = $row->category_name;
				$response[$i]['vendor_type_name'] = $row->vendor_type_name;
                $response[$i]['action'] = '<a href="'.url("service/edit",[$row->service_id]).'">Edit</a>';
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
            Service::where(['service_id'=>$value])->delete();
        }
    }

    

    
    
}
