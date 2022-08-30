<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Auth;

class LaboratoryController extends Controller
{
    //
    // public function __construct()
    // {
    //     $this->middleware('auth:laboratory');
    // }

    public function dashboardLaboratory(){
        return view('laboratory.dashboard');
    }

    public function authenticate(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(Auth::guard('laboratory')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
            return redirect()->route('laboratory.dashboard');
        }
        else{
            session()->flash('error','Either Email/Password is incorrect');
            return back()->withInput($request->only('email'));
        }
    }

    public function reportsView()
    {
        $laboratorytests=\App\Models\LaboratoryTest::all();
        return view('laboratory.add_report',['laboratorytests'=>$laboratorytests]);
    }

    public function reports(Request $request){
        $laboratoryreport=new \App\Models\LaboratoryReport;
        $laboratoryreport->test_id=$request->test_id;
        $laboratoryreport->description=$request->description;
        $laboratoryreport->date=$request->date;
        $laboratoryreport->result=$request->result;
        $laboratoryreport->save();
        return redirect()->back()->with('message','Report made Successfully');
    }

    public function myreports(){
        // $userid=Auth::user()->id();
        $laboratoryreports=\App\Models\LaboratoryReport::get();
        return view('laboratory.my_reports',['laboratoryreports'=>$laboratoryreports]);
    }

    public function logout(){
        Auth::guard('laboratory')->logout();
        return redirect()->route('laboratory.login');
    }
}
