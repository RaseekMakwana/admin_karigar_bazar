<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use App\Models\VendorType;


class DataController extends Controller
{
    public function temp_data(){
        $data = VendorType::select('vendor_type_id')->get();
        foreach($data as $row){

            $updateData = array(
                'vendor_type_id' => uniqid() 
            );
            VendorType::where('vendor_type_id', $row->vendor_type_id)
                ->update($updateData);
        }
    }
}
