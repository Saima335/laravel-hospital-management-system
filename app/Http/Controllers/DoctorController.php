<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DoctorController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:doctor');
    // }

    public function dashboardDoctor(){
        return view('doctor.dashboard');
    }

    public function authenticate(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(Auth::guard('doctor')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
            return redirect()->route('doctor.dashboard');
        }
        else{
            session()->flash('error','Either Email/Password is incorrect');
            return back()->withInput($request->only('email'));
        }
    }

    public function add(Request $request){
        $model=new \App\Models\Doctor;
        $model->name=$request->name;
        $model->email=$request->email;
        $model->password=Hash::make($request->password);
        $model->save();
        if(Auth::guard('doctor')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
            return redirect()->route('doctor.dashboard');
        }
    }

    public function logout(){
        Auth::guard('doctor')->logout();
        return redirect()->route('doctor.login');
    }

    public function treatmentView(){
        // $appointments=\App\Models\Appointment::where([
        //     ["status","=","Approved"],
        //     ["doctor_id","=",Auth::user()->id]
        // ])->get();
        $patients=\App\Models\Patient::all();
        $medicines=\App\Models\Medicine::all();
        // $prescribedmedicines=\App\Models\PrescribedMedicine::all();
        return view('doctor.treatment',['patients'=>$patients,'medicines'=>$medicines]);
    }

    public function treatment(Request $request){
        dd($request->all());
        $treatment=new \App\Models\Treatment;
        $treatment->patient_id=$request->patient_id;
        $treatment->doctor_id=$request->doctor_id;
        $treatment->date=$request->date;
        $treatment->fees=$request->fees;
        $treatment->note=$request->note;
        $treatment->save();
        for($i = 0; $i < count($request->medicine_id); $i++) {
            $treatment->medicines()->attach([
                $request->medicine_id[$i]=>[
                    'dosage'=>$request->dosage[$i],
                    'days'=>$request->days[$i],
                ]
            ]);
        }
        for($i = 0; $i < count($request->test_name); $i++) {
            $laboratorytest=new \App\Models\LaboratoryTest;
            $laboratorytest->treatment_id=$treatment->id;
            $laboratorytest->name=$request->test_name[$i];
            $laboratorytest->date=$request->test_date[$i];
            $laboratorytest->amount=$request->amount[$i];
            $laboratorytest->save();
        }
        return redirect()->back()->with('message','Prescription Done Successfully');
    }

    public function mytreatment(){
        // $treatments=\App\Models\Treatment::with(['medicines','patient'])->get();
        $treatments=\App\Models\Treatment::get();
        return view('doctor.my_treatment',['treatments'=>$treatments]);
    }

    public function try(Request $request){
        dd($request->all());

    }

    public function showforgetForm(){
        return view('doctor.password.forget');
    }

    public function sendResetLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:doctors,email'
        ]);
        $token=\Str::random(64);
        \DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
        ]);
        $action_link=route('doctor.resetFormShow',['token'=>$token,'email'=>$request->email]);
        $body="We have received a request to reset the password <b>Hospital Management System</b> account associated with ".$request->email.".You can reset your password by clicking the link below.";
        \Mail::send('layouts\email-forget',['action_link'=>$action_link,'body'=>$body],function($message) use ($request){
            $message->from('noreply@example.com','Hospital Management System');
            $message->to($request->email,'Doctor Name')
            ->subject('Reset Password');
        });
        return back()->with('success','We have e-mailed your password reset link');
    }
    public function showResetForm(Request $request,$token=null){
        return view('doctor.password.reset')->with(['token'=>$token,'email'=>$request->email]);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email'=>'required|email|exists:doctors,email',
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
            \App\Models\Doctor::where('email', $request->email)->update([
               'password'=>\Hash::make($request->password)
           ]);

           \DB::table('password_resets')->where([
               'email'=>$request->email
           ])->delete();

           return redirect()->route('doctor.login')->with('info', 'Your password has been changed! You can login with new password')->with('verifiedEmail', $request->email);
       }
    }
}
