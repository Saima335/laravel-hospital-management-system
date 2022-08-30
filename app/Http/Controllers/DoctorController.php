<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Auth;
use Illuminate\Support\Facades\Hash;

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
        $patients=\App\Models\User::all();
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
}
