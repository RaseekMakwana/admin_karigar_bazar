<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper;

class Category extends Model
{
    use HasFactory;

	protected $table = "category_master";

	public $fillable = ['category_id','category_slug','category_name','picture_thumb'];

	public static function load_manage_data($request){
		return Category::all()->sortByDesc("created_at");
	}

	public static function getCategoryByCategoryId($category_id){
		return Category::where("category_id",$category_id)
					->first();
	}

	/*
		request: comma separated ids
	*/
	public static function getCategoryByCategoryIds($category_id){
		$explode_ids = explode(",", $category_id);
		return Category::whereIn("category_id", $explode_ids)->get()->sortByDesc("category_name");
	}

	public static function getCategoryNotMappedWithVendorId($user_id){
		$selectAttributes = array(
			"category_id",
			"category_name",
		);
		return Category::select($selectAttributes)
				->where(["status" => '1'])
				->whereRaw("`category_id` NOT IN (SELECT DISTINCT `category_id` FROM `vendor_service_master` WHERE `user_id`='".$user_id."')")
				->get()
				->sortBy("category_name");
	}
	


}
