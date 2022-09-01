<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Auth;
use Carbon\Carbon;

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

    public function showforgetForm(){
        return view('laboratory.password.forget');
    }

    public function sendResetLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:laboratories,email'
        ]);
        $token=\Str::random(64);
        \DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
        ]);
        $action_link=route('laboratory.resetFormShow',['token'=>$token,'email'=>$request->email]);
        $body="We have received a request to reset the password <b>Hospital Management System</b> account associated with ".$request->email.".You can reset your password by clicking the link below.";
        \Mail::send('layouts\email-forget',['action_link'=>$action_link,'body'=>$body],function($message) use ($request){
            $message->from('noreply@example.com','Hospital Management System');
            $message->to($request->email,'Laboratory Name')
            ->subject('Reset Password');
        });
        return back()->with('success','We have e-mailed your password reset link');
    }
    public function showResetForm(Request $request,$token=null){
        return view('laboratory.password.reset')->with(['token'=>$token,'email'=>$request->email]);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email'=>'required|email|exists:laboratories,email',
            'password'=>'required|min:5|confirmed',
            'password_confirmation'=>'required',
       ]);

       $check_token = \DB::table('password_resets')->where([
            'email'=>$request->email,
            'token'=>$request->token,
       ])->first();

       if(!$check_token){
           return back()->withInput()->with('fail', 'Invalid token');
       }else{
            \App\Models\Laboratory::where('email', $request->email)->update([
               'password'=>\Hash::make($request->password)
           ]);

           \DB::table('password_resets')->where([
               'email'=>$request->email
           ])->delete();

           return redirect()->route('laboratory.login')->with('info', 'Your password has been changed! You can login with new password')->with('verifiedEmail', $request->email);
       }
    }
}
