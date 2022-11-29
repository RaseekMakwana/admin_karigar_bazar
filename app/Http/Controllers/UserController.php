<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\State;
use App\Models\Device;
use App\Models\Vendor;
use App\Models\VendorService;
use App\Models\Service;
use App\Models\UserLoginLog;

class UserController extends Controller
{

    public function index(){
        $data['state_data'] = State::select('state_id','state_name')->get();
        return view('user.index', compact('data'));
    }

    public function load_manage_data(Request $request){
        $input = $request->input();
		$result = User::load_manage_data($input);
		$response = array();
		$i = 0;
		if(!empty($result)){
			foreach($result as $key => $row){
				$response[$i]['no'] = '<input type="checkbox" name="checkbox" class="checkbox_2 checkbox" value="'.$row->user_id.'">';
				$response[$i]['name'] = $row->name;
				$response[$i]['mobile'] = $row->mobile;
				$response[$i]['user_type'] = $row->user_type;

                $link = "<a href='".URL('user/view/'.$row->user_id)."'>View</a>";
                if($row->user_type == "Vendor"){
                    $link .= " | <a href='".URL('vendor/edit/'.$row->user_id)."'>Edit Vendor</a>";
                    $link .= " | <a href='".URL('vendor_service/manage/'.$row->user_id)."'>Service</a>";
                }
				$response[$i]['action'] = $link;
				$i++;
			}
		} 
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
    }

    public function view($user_id){
        $data['profile'] = User::getUserByAttribute(["user_id"=>$user_id]);
        $data['vendor'] = Vendor::getVendorByAttribute(["user_id"=>$user_id]);
        $data['vendor_service'] = VendorService::getVendorServiceByAttribute(["user_id"=>$user_id]);
        // p($data['vendor']);
        $vendor_service_array = array();
        foreach($data['vendor_service'] as $row){
            $service_data = Service::getServicesByServiceIds(explode(",",$row->service_id));
            $category_service = array();
            foreach($service_data AS $service_row){
                $category_service[] = array(
                    "service_id" => $service_row->service_id,
                    "service_name" => $service_row->service_name
                );
            }
            $vendor_service_array[] = array(
                "category_name" => $row->category_name,
                "category_service" => $category_service
            );
        }

        $data['vendor_service'] = $vendor_service_array;
        // p($da/ta['vendor_service']);
        return view('user.view', compact('data'));
    }
    // public function project($user_id){
    //     $data['profile'] = User::getUserByAttribute(["user_id"=>$user_id]);
    //     $data['vendor'] = Vendor::getVendorByAttribute("user_id",$user_id);
    //     // $data['vendor_service'] = VendorService::getVendorServiceByAttribute(["user_id"=>$user_id]);
    //     return view('user.project', compact('data'));
    // }


    public function delete(Request $request){
        $input = $request->input();
        $expload_values = explode(',',$input['checked_values']);
        foreach($expload_values as $key => $user_id){
            User::activeDeactiveUserByUserId($user_id);
            Device::activeDeactiveDeviceByUserId($user_id);
            Vendor::activeDeactiveVendorByUserId($user_id);
            VendorService::activeDeactiveVendorServiceByUserId($user_id);
        }
    }

    public function permanent_delete(Request $request){
        $input = $request->input();
        $expload_values = explode(',',$input['checked_values']);
        foreach($expload_values as $key => $user_id){
            $user_profile_picture = User::getAttributesByUserId(["profile_picture"],$user_id);
            if(!empty($user_profile_picture->profile_picture)){
                $path = config('app.storage_path').$user_profile_picture->profile_picture;
                unlink($path);
            }

            User::removeUserByUserId($user_id);
            Device::removeDeviceByUserId($user_id);
            Vendor::removeVendorByUserId($user_id);
            VendorService::removeVendorServiceByUserId($user_id);
            UserLoginLog::removeUserLoginLogByUserId($user_id);
        }
    }

}
