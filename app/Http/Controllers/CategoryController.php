<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function create(){
        // $data['vendor_type_data'] = VendorType::select('vendor_type_id','vendor_type_name')->orderBy('vendor_type_name','asc')->get();
        return view('category.create');
    }
    public function edit($category_ids){
        $data['category_data'] = Category::getCategoryByCategoryIds($category_ids);
        return view('category.edit', compact('data'));
    }

    public function store(Request $request){
        $input = $request->input();
        if(!empty($input['category_name'])){
            foreach($input['category_name'] as $key => $value){
                $insertData = array(
                    "category_id" => uniqid(),
                    "category_slug"=> Helper::createUrlSlug($value),
                    "category_name" => ucwords($value),
                );
                Category::create($insertData);
            }
            return redirect("category/manage")->with('success_message', 'Category has been created successfully');
        }
    }

    public function update(Request $request){
        $input = $request->input();
        if(!empty($input['new_category_name'])){
            foreach($input['new_category_name'] as $key => $value){
                $insertData = array(
                    "category_id" => uniqid(),
                    "category_slug" => Helper::createUrlSlug($value),
                    "category_name" => ucwords($value),
                );
                Category::create($insertData);
            }
        }

        if(!empty($input['update_category_name'])){
            foreach($input['update_category_name'] as $key => $value){
                $updateData = array(
                    "category_slug" => Helper::createUrlSlug($value),
                    "category_name" => ucwords($value),
                );
                Category::where('category_id', $key)->update($updateData);
            }
        }
        if(!empty($input['removed_category'])){
            foreach($input['removed_category'] as $key => $value){
                Category::where(['category_id'=>$value])->delete();
            }
        }
        
        return redirect("category/manage")->with('success_message', 'Category has been updated successfully');
    }

    public function manage(){
        // $data['vendor_type_data'] = VendorType::select('vendor_type_id','vendor_type_name')->get();
        return view('category.manage');
    }
    public function load_manage_data(Request $request){
        $input = $request->input();

		$result = Category::load_manage_data($request);
		$response = array();
		$i = 0;
		if(!empty($result)){
            // p($result);
			foreach($result as $key => $row){
				$response[$i]['no'] = '<input type="checkbox" name="checkbox" class="checkbox_2 checkbox" value="'.$row->category_id.'">'; 
				$response[$i]['category_name'] = $row->category_name;
				$response[$i]['action'] = '<a href="'.url("category/edit",[$row->category_id]).'">Edit</a>';
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
            Category::where(['category_id'=>$value])->delete();
        }
    }

    

    
    
}
