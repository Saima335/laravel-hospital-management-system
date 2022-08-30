<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $user;
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function appointmentView()
    {
        $doctors=\App\Models\Doctor::all();
        return view('appointment',['doctors'=>$doctors]);
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
        return view('my_appointment',['appointments'=>$appointments]);
    }

    public function viewreports(){
        // $userid=Auth::user()->id();
        $laboratoryreports=\App\Models\LaboratoryReport::get();
        return view('view_report',['laboratoryreports'=>$laboratoryreports]);
    }

    public function cancelappoint($id){
        $appointment=\App\Models\Appointment::find($id);
        $appointment->delete();
        return redirect()->back();
    }
}
