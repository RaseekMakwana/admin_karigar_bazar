<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorType extends Model
{
    use HasFactory;

	protected $table = "vendor_type_master";

	public static function getVendorType(){
        return VendorType::where("status",'1')->get();
	}

}
