<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{   
    public function dashboardAdmin(){
        return view('admin.dashboard');
    }

    public function dashboardDoctor(){
        return view('doctor.dashboard');
    }

    public function dashboardLaboratory(){
        return view('laboratory.dashboard');
    }
}
