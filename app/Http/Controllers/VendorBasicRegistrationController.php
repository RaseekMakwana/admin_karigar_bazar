<?php

namespace App\Http\Controllers;

use App\Models\VendorBasicRegistration;
use Illuminate\Http\Request;

class VendorBasicRegistrationController extends Controller
{

	public function manage(){
        return view('vendor_basic_registration.manage');
	}
    public function load_manage_data(Request $request){
        $input = $request->input(); 
		$result = VendorBasicRegistration::load_manage_data($request);
		$response = array();
		$i = 0;
		if(!empty($result)){
			foreach($result as $key => $row){
				if(!empty($input['filter_action'])){
					$response[$i]['no'] = "<input type='checkbox' name='checkbox' class='checkbox_2 checkbox' value='".$row->user_id."'>";
				} else {
					$color = "";
					if($row->status == "1"){
						$color = "blue";
					} else if($row->status == "2"){
						$color = "green";
					} else if($row->status == "3"){
						$color = "red";
					}
					$response[$i]['no'] = "<i class='fa fa-circle' style='color: $color'></i>";
				}

				// $response[$i]['no'] = $i+1;
				$response[$i]['vendor_name'] = "<a href='javascript:void(0)' class='view_detail' data-id='".$row->user_id."'>".$row->vendor_name."</a>";
				$response[$i]['mobile'] = $row->mobile;
				$response[$i]['occupation'] = $row->occupation;
				$response[$i]['area_name'] = $row->area;
				$response[$i]['city_name'] = $row->city;
				$response[$i]['state_name'] = $row->state;
				$response[$i]['created_at'] = date("d-m-Y h:i A", strtotime($row->created_at));
				$response[$i]['action'] = "<a href='".url('vendor/create/'.$row->user_id)."' class='".$row->user_id."' data-id='".$row->user_id."'>Create</a>";
				$i++;
			}
		} 
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
    }

	public function detail_view(Request $request){
		$input = $request->input();
		$vendor_detail = VendorBasicRegistration::get_vendor_details($request);
		return view('vendor_basic_registration._view_detail_html', compact('vendor_detail'))->render();
	}

	public function approve_reject_delete_action(Request $request){
		$input = $request->input();
		if($input['action_flag'] == "approve"){
			$action_flag = explode(",",$input['checked_values']);
			foreach($action_flag  as $value){
				VendorBasicRegistration::vendor_approve($value);
			}
		}
		if($input['action_flag'] == "reject"){
			$action_flag = explode(",",$input['checked_values']);
			foreach($action_flag  as $value){
				VendorBasicRegistration::vendor_reject($value);
			}
		}
		if($input['action_flag'] == "delete"){
			$action_flag = explode(",",$input['checked_values']);
			foreach($action_flag  as $value){
				VendorBasicRegistration::vendor_delete($value);
			}
		}
	}
}
