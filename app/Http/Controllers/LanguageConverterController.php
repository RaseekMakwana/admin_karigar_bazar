<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageConverterController extends Controller
{
    public function index(){
        return view("language_converter.index");
    }
    
    public function convert(Request $request){
        $input = $request->input();
        $languageArray = [
                [ "language_name"=>'English', "language_code"=>'en' ],
                [ "language_name"=>'Hindi', "language_code"=>'hi' ],
                [ "language_name"=>'Gujarati', "language_code"=>'gu' ],
                [ "language_name"=>'Marathi', "language_code"=>'mr' ],
                [ "language_name"=>'Bengali', "language_code"=>'bn' ],
                [ "language_name"=>'Odia Oriya', "language_code"=>'or' ],
                [ "language_name"=>'Punjabi', "language_code"=>'pa' ],
                [ "language_name"=>'Telugu', "language_code"=>'te' ],
                [ "language_name"=>'Tamil', "language_code"=>'ta' ],
                [ "language_name"=>'Kannada', "language_code"=>'kn' ],
                [ "language_name"=>'Malayalam', "language_code"=>'ml' ],
                [ "language_name"=>'Assamese', "language_code"=>'as' ],
            ];
        $data = [];
        $i=0;
        foreach($languageArray as $value){
            $convert_data = json_decode(file_get_contents('https://translate.googleapis.com/translate_a/t?client=dict-chrome-ex&sl=en&tl='.$value['language_code'].'&dt=t&q='.urlencode($input['input_text']).'&ie=UTF-8&oe=UTF-8'));
            $data[$i]['language_name'] = $value['language_name'];
            $data[$i]['language_code'] = $value['language_code'];
            $data[$i]['convert_value'] = $convert_data[0];
            $i++;
        }
        return response()->json($data);
    }

    public function languageInputTranslate(){
        return view("language_converter.language_input_translate");
    }
}
