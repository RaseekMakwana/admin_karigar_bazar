<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\VendorBasicRegistration;
use App\Models\VendorType;
use App\Models\User;
use App\Models\Device;
use App\Models\Vendor;
use App\Models\VendorService;
use App\Models\Area;


class VendorController extends Controller
{

    public function index(){
        $data['state_data'] = State::select('state_id','state_name')->get();
        return view('vendor.index', compact('data'));
    }

    public function create($user_id = null) {
        $vendor_data = VendorBasicRegistration::getVendorById($user_id);
        $data['state_data'] = State::getState();

        $data['vendor_source'] = "direct";
        if(!empty($user_id)){
            $data['vendor_source'] = "by_vendor";
            $data['vendor_data'] = $vendor_data;
        } 

        return view('vendor.create', compact('data'));
    }

    public function store(Request $request){
        $input = $request->input();
        // p($request);

        $user_id = md5(time().$input['mobile_number']);
        $user_data = User::getUserByMobile($input['mobile_number']);
        // DB::enableQuerylog();
        if(empty($user_data)){
            $user = new User();
            $user->user_id = $user_id;
            $user->name = ucwords($input['vendor_name']);
            $user->mobile = $input['mobile_number'];
            $user->user_type = "Vendor";
            $user->save();
        } else {
            $user_id = $user_data->user_id;
            $updateData = array(
                "user_id" => $user_id,
                "name" => ucwords($input['vendor_name']),
                "user_type" => "Vendor",
            );
            User::where('mobile', $input['mobile_number'])->update($updateData);
        }
        
        // vendor_master
        $vendor = new Vendor();
        $vendor->user_id = $user_id;
        $vendor->vendor_name = ucwords($input['vendor_name']);
        $vendor->business_name = ucwords($input['business_name']);
        $vendor->mobile = $input['mobile_number'];
        $vendor->state_id = $input['state'];
        $vendor->city_id = $input['city'];
        $vendor->area = ucwords($input['area']);
        $vendor->pin_code = $input['pin_code'];
        $vendor->save();
        

        if($input['action'] == "by_vendor"){
            $updateData = array(
                "status" => '2',
            );
            VendorBasicRegistration::where('mobile', $input['mobile_number'])->update($updateData);
        }
        return redirect("user/manage")->with('success_message', 'Vandor has been created successfully');
        

        

        // $user_id = md5(time().$input['mobile_number']);
        // $insertData = array(
        //     "user_id" => $user_id,
        //     "vendor_name" => ucwords($input['vendor_name']),
        //     "business_name" => ucwords($input['business_name']),
        //     "mobile" => $input['mobile_number'],
        //     "state_id" => $input['state'],
        //     "city_id" => $input['city'],
        //     "area" => $input['area'],
        //     "pin_code" => $input['pin_code'],
        //     "password" => md5($input['password'])
        // );
        // Vendor::insert($insertData);

        // return redirect("vendor/create")->with('success_message', 'Vandor has been created successfully');
    }
    

    public function edit($user_id){
        $vendor_detail = Vendor::select('*')->where(['user_id'=>$user_id])->first();
        $data['state_data'] = State::select('state_id','state_name')->get();
        $data['city_data'] = City::select('city_id','city_name')->where(['state_id'=>$vendor_detail->state_id])->get();
        $data['vendor_detail'] = $vendor_detail;

        return view('vendor.edit', compact('data'));
    }

    public function update(Request $request){
        $input = $request->input();

        $updateData = array(
            "vendor_name" => $input['vendor_name'],
            "business_name" => $input['business_name'],
            "mobile" => $input['mobile_number'],
            "state_id" => $input['state'],
            "city_id" => $input['city'],
            "area" => $input['area'],
            "pin_code" => $input['pin_code'],
        );
        Vendor::where(['user_id'=>$input['user_id']])->update($updateData);

        return redirect("user/manage")->with('success_message', 'Vandor has been updated successfully');
        
    }

    public function get_cities_by_state_id(Request $request){
        $input = $request->input();
        $cities_data = City::select('city_id','city_name')->where('state_id',$input['state_id'])->get();
        return response()->json($cities_data);
    }
    public function get_area_by_city_id(Request $request){
        $input = $request->input();
        $area_data = Area::select('area_id','area_name')->where('city_id',$input['city_id'])->get();
        return response()->json($area_data);
    }

    public function check_vendor_mobile_exist(Request $request){
        $input = $request->input();
        if(!empty($input['user_id'])){
            $data = User::where(['mobile'=>$input['mobile_number'], 'user_type'=> 'vendor'])->whereNotIn("user_id",[$input['user_id']])->count();
        } else {
            $data = User::where(['mobile'=>$input['mobile_number'], 'user_type'=> 'vendor'])->count();
        }
        return response()->json($data);
    }

    

    public function load_manage_data(Request $request){
        $input = $request->input();
		$result = Vendor::load_manage_data($request);
		$response = array();
		$i = 0;
		if(!empty($result)){
			foreach($result as $key => $row){
				$response[$i]['no'] = '<input type="checkbox" name="checkbox" class="checkbox_2 checkbox" value="'.$row->user_id.'">';
				$response[$i]['vandor_name'] = $row->vendor_name;
				$response[$i]['mobile'] = $row->mobile;
				$response[$i]['area_name'] = $row->area;
				$response[$i]['city_name'] = $row->city_name;
				$response[$i]['state_name'] = $row->state_name;
				$response[$i]['action'] = "<a href='".URL('vendor/edit/'.$row->user_id)."'>Edit</a> | <a href='".URL('vendor_service/manage/'.$row->user_id)."'>Service</a>";
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
        }
    }

    public function createByVendor($user_id){
        $vendor_data = VendorBasicRegistration::getVendorById($user_id);
        $vendor_type_data = VendorType::getVendorType();
        if(!empty($vendor_data)){
            $data['state_data'] = State::getState();
            $data['vendor_data'] = $vendor_data;
            $data['vendor_type_data'] = $vendor_type_data;
            return view('vendor.create_by_vendor', compact('data'));
        } else {
            return redirect("user/manage")->with('success_message', 'User not found');
        }
    }

    public function storeByVendor(Request $request){
        $input = $request->input();
        // p($request);

        $vendor_details = VendorBasicRegistration::getVendorByMobile($input['mobile_number']);
        if($vendor_details){

            $user_id = md5(time().$input['mobile_number']);
            $user_data = User::getUserByMobile($input['mobile_number']);
            if(empty($user_data)){
                $user = new User();
                $user->user_id = $user_id;
                $user->name = ucwords($input['vendor_name']);
                $user->mobile = $input['mobile_number'];
                $user->user_type = "Vendor";
                $user->save();
                
            } else {
                $updateData = array(
                    "user_id" => $user_id,
                    "name" => ucwords($input['vendor_name']),
                    "user_type" => "Vendor",
                );
                User::where('mobile', $input['mobile_number'])->update($updateData);
            }

            // vendor_master
            $vendor = new Vendor();
            $vendor->user_id = $user_id;
            $vendor->vendor_name = ucwords($input['vendor_name']);
            $vendor->business_name = ucwords($input['business_name']);
            $vendor->mobile = ucwords($input['mobile_number']);
            $vendor->state_id = $input['state'];
            $vendor->city_id = $input['city'];
            $vendor->area = ucwords($input['area']);
            $vendor->pin_code = $input['pin_code'];
            $vendor->save();

            // vendor_basic_registration
            $updateData = array(
                "status" => '2',
            );
            VendorBasicRegistration::where('user_id', $vendor_details->user_id)->update($updateData);
        }

        return redirect("vendor_basic_registration/manage")->with('success_message', 'Vandor has been created successfully');
    }


    
    
}
