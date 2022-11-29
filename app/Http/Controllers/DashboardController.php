<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.index');
    }

    
    
}
