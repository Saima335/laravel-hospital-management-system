<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PatientController extends Controller
{
    //
    public function authenticate(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(Auth::guard('patient')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
            return redirect()->route('patient.dashboard');
        }
        else{
            session()->flash('error','Either Email/Password is incorrect');
            return back()->withInput($request->only('email'));
        }
    }

    public function add(Request $request){
        $model=new \App\Models\Patient;
        $model->name=$request->name;
        $model->email=$request->email;
        $model->password=Hash::make($request->password);
        $model->save();
        if(Auth::guard('patient')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
            return redirect()->route('patient.dashboard');
        }
    }

    public function logout(){
        Auth::guard('patient')->logout();
        return redirect()->route('patient.login');
    }

    public function index()
    {
        return view('patient.dashboard');
    }

    public function appointmentView()
    {
        $doctors=\App\Models\Doctor::all();
        return view('patient.appointment',['doctors'=>$doctors]);
    }

    public function appointment(Request $request){
        $appointment=new \App\Models\Appointment;
        $appointment->patient_id=$request->patient_id;
        $appointment->doctor_id=$request->doctor_id;
        $appointment->date=$request->date;
        $appointment->time=$request->time;
        $appointment->description=$request->description;
        $appointment->status='In Progress';
        $appointment->save();
        return redirect()->back()->with('message','Appointment Request Successfull. We will contact you soon');
    }

    public function myappointment(){
        // $userid=Auth::user()->id();
        $appointments=\App\Models\Appointment::get();
        return view('patient.my_appointment',['appointments'=>$appointments]);
    }

    public function viewreports(){
        // $userid=Auth::user()->id();
        $laboratoryreports=\App\Models\LaboratoryReport::get();
        return view('patient.view_report',['laboratoryreports'=>$laboratoryreports]);
    }

    public function cancelappoint($id){
        $appointment=\App\Models\Appointment::find($id);
        $appointment->delete();
        return redirect()->back();
    }

    public function showforgetForm(){
        return view('patient.password.forget');
    }

    public function sendResetLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:patients,email'
        ]);
        $token=\Str::random(64);
        \DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
        ]);
        $action_link=route('patient.resetFormShow',['token'=>$token,'email'=>$request->email]);
        $body="We have received a request to reset the password <b>Hospital Management System</b> account associated with ".$request->email.".You can reset your password by clicking the link below.";
        \Mail::send('layouts\email-forget',['action_link'=>$action_link,'body'=>$body],function($message) use ($request){
            $message->from('noreply@example.com','Hospital Management System');
            $message->to($request->email,'Patient Name')
            ->subject('Reset Password');
        });
        return back()->with('success','We have e-mailed your password reset link');
    }
    public function showResetForm(Request $request,$token=null){
        return view('patient.password.reset')->with(['token'=>$token,'email'=>$request->email]);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email'=>'required|email|exists:patients,email',
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
            \App\Models\Patient::where('email', $request->email)->update([
               'password'=>\Hash::make($request->password)
           ]);

           \DB::table('password_resets')->where([
               'email'=>$request->email
           ])->delete();

           return redirect()->route('patient.login')->with('info', 'Your password has been changed! You can login with new password')->with('verifiedEmail', $request->email);
       }
    }
}
