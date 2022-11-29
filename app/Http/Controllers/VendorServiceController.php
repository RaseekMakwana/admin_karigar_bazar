<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorService;
use App\Models\Service;
use App\Models\Category;
use App\Helpers\CommonHelper;
use App\Models\Vendor;


class VendorServiceController extends Controller
{
    public function create($user_id){
        // $data['vendor_data'] = Vendor::select('user_id','vendor_name')->where("user_id", $user_id)->first();
        // $vendor_service_data = DB::Table('vendor_service_master')->select('category_id')->where("user_id", $user_id)->get();
        // $ignore_ids = array();
        // foreach($vendor_service_data as $row){
            //     $ignore_ids[] = $row->category_id;
            // }
        $data['selected_user_id'] = $user_id;
        $data['category_data'] = Category::getCategoryNotMappedWithVendorId($user_id);   // Category::select('category_id','category_name')->whereNotIn('category_id',$ignore_ids)->orderBy('category_name','asc')->get();
        return view('vendor_service.create', compact('data'));
    }

    public function edit($user_id, $category_id){
        $data['vendor_service_data'] = VendorService::from('vendor_service_master as vsm')
                                        ->select('vsm.user_id', 'vsm.category_id', 'cm.category_name', 'vsm.service_id')
                                        ->leftjoin('category_master as cm','cm.category_id','=','vsm.category_id')
                                        ->where(["user_id" => $user_id, 'vsm.category_id' => $category_id])
                                        ->first();
        $data['service_data'] = Service::select('service_id','service_name')->where("category_id", $category_id)->get();      
        return view('vendor_service.edit', compact('data'));
    }

    public function store(Request $request){
        $input = $request->input();
        if($input['action'] == "create"){
            // if(!empty($input['selected_services'])){
                $vendor_data = Vendor::select('user_id','state_id','city_id')->where("user_id", $input['user_id'])->first();

                $insertData = array(
                    "user_id" => $vendor_data->user_id,
                    "category_id" => $input['category_id'],
                    "service_id" => (!empty($input['selected_services']))? implode(",",$input['selected_services']) : "",
                    "state_id" => $vendor_data->state_id,
                    "city_id" => $vendor_data->city_id,
                );
                VendorService::create($insertData);

                return redirect("vendor_service/manage/".$vendor_data->user_id)->with('success_message', 'Services has been created successfully');
            // }
            
        } else if($input['action'] == "edit"){
            // if(!empty($input['selected_services'])){
                $updateData = array(
                    "service_id" => !empty($input['selected_services'])? implode(",",$input['selected_services']) : '',
                );
                VendorService::where(['user_id'=> $input['user_id'],'category_id'=>$input['category_id']])
                        ->update($updateData);
            // }

            return redirect("vendor_service/manage/".$input['user_id'])->with('success_message', 'Services has been updated successfully');
        }
    }

    public function manage($user_id){
        $data['vendor_data'] = Vendor::select('user_id','vendor_name')->where("user_id", $user_id)->first();
        return view('vendor_service.manage', compact('data'));
    }
    public function load_manage_data(Request $request){
        $input = $request->input();

		$result = VendorService::load_manage_data($request);
		$response = array();
		$i = 0;
		if(!empty($result)){
            // p($result);
			foreach($result as $key => $row){
                $service_id = explode(",",$row->service_id);
                $services_name = Service::select('service_name')->whereIn('service_id', $service_id)->get();

                $html = "";
                foreach($services_name as $service_row){
                    $html .= '<span class="badge bg-primary">'.$service_row->service_name.'</span> ';
                }

				$response[$i]['no'] = "<input type='checkbox' name='checkbox' class='checkbox_2 checkbox' value='".$row->category_id."'>";
				$response[$i]['services_name'] = $html;
				$response[$i]['category_name'] = $row->category_name;
				$response[$i]['city_name'] = $row->city_name;
				$response[$i]['state_name'] = $row->state_name;
				$response[$i]['action'] = '<a href="'.URL('vendor_service/edit/'.$row->user_id.'/'.$row->category_id).'">Edit</a>';
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
            VendorService::where(['user_id'=>$input['user_id'],'category_id'=>$value])->delete();
        }
    }

    

    
    
}
