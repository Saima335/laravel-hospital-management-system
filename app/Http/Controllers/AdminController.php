<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Auth;
use Illuminate\Support\Facades\Hash;
use \App\Models\Doctor;
use \App\Models\Medicine;
use \App\Models\Laboratory;
use Carbon\Carbon;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:admin');
    // }

    public function dashboardAdmin(){
        return view('admin.dashboard');
    }

    public function authenticate(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
            return redirect()->route('admin.dashboard');
        }
        else{
            session()->flash('error','Either Email/Password is incorrect');
            return back()->withInput($request->only('email'));
        }
    }

    public function add(Request $request){
        $model=new \App\Models\Admin;
        $model->name=$request->name;
        $model->email=$request->email;
        $model->password=Hash::make($request->password);
        $model->save();
        if(Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
            return redirect()->route('admin.dashboard');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function addDoctorView(){
        return view('admin.add_doctor');
    }

    public function upload(Request $request){
        // dd($request->all());
        $doctor=new \App\Models\Doctor;
        $image=$request->file;
        $imagename=time().'.'.$image->getClientoriginalExtension();
        $request->file->move('doctorimage',$imagename);
        $doctor->image=$imagename;
        $doctor->name=$request->name;
        $doctor->email=$request->email;
        $doctor->password=Hash::make($request->password);
        $doctor->speciality=$request->speciality;
        $doctor->save();
        return redirect()->back()->with('message','Doctor Added Successfully!');
    }

    public function showappointments(){
        $appointments=\App\Models\Appointment::get();
        return view('admin.showappointments',['appointments'=>$appointments]);
    }

    public function approve($id){
        $appointment=\App\Models\Appointment::find($id);
        $appointment->status='Approved';
        $appointment->save();
        return redirect()->back();
    }

    public function cancel($id){
        $appointment=\App\Models\Appointment::find($id);
        $appointment->status='Canceled';
        $appointment->save();
        return redirect()->back();
    }

    public function index(){
        $doctors = Doctor::orderBy('id','DESC')->get();
        return view('admin.showdoctors',['doctors'=>$doctors]);
    }

    public function addDoctor(Request $request){
        // dd($request->all());
        $doctor=new Doctor;
        $image=$request->file;
        $imagename=time().'.'.$image->getClientoriginalExtension();
        $request->file->move('doctorimage',$imagename);
        $doctor->image=$imagename;
        $doctor->name=$request->name;
        $doctor->email=$request->email;
        $doctor->password=Hash::make($request->password);
        $doctor->speciality=$request->speciality;
        $doctor->save();
        // return redirect()->back()->with('message','Doctor Added Successfully!');
        // return response()->json($doctor);
        return response()->json
        ([
            'message' => 'Doctor was successfully added',
            'doctor' => $doctor
       ]);
    }

    public function getDoctor(){
        $doctors=Doctor::all();
        return response()->json($doctors);
    }

    public function getDoctorById($id){
        $doctor=Doctor::find($id);
        return response()->json($doctor);
    }

    public function updateDoctor(Request $request){
        // dd($request->all());
        $doctor=Doctor::find($request->id);
        if($request->file){
            $image=$request->file;
            $imagename=time().'.'.$image->getClientoriginalExtension();
            $request->file->move('doctorimage',$imagename);
            $doctor->image=$imagename;
        }
        $doctor->name=$request->name;
        $doctor->email=$request->email;
        // $doctor->password=$request->password;
        $doctor->speciality=$request->speciality;
        $doctor->save();
        return response()->json($doctor);
    }

    public function deleteDoctor($id){
        $doctor=Doctor::find($id);
        $doctor->delete();
        return response()->json(['success'=>'Record has been deleted']);
    }

    public function deleteCheckedDoctors(Request $req){
        $ids=$req->ids;
        Doctor::whereIn('id',$ids)->delete();
        return response()->json(['success'=>'Doctors have been deleted!']);
    }

    public function addMedicineView(){
        return view('admin.add_medicine');
    }

    public function indexMedicine(){
        $medicines = Medicine::orderBy('id','DESC')->get();
        return view('admin.showmedicines',['medicines'=>$medicines]);
    }

    public function addMedicine(Request $request){
        // dd($request->all());
        $medicine=new Medicine;
        $medicine->name=$request->name;
        $medicine->type=$request->type;
        $medicine->save();
        return response()->json
        ([
            'message' => 'Medicine was successfully added',
            'medicine' => $medicine
       ]);
    }

    public function getMedicine(){
        $medicines=Medicine::all();
        return response()->json($medicines);
    }

    public function getMedicineById($id){
        $medicine=Medicine::find($id);
        return response()->json($medicine);
    }

    public function updateMedicine(Request $request){
        // dd($request->all());
        $medicine=Medicine::find($request->id);
        $medicine->name=$request->name;
        $medicine->type=$request->type;
        $medicine->save();
        return response()->json($medicine);
    }

    public function deleteMedicine($id){
        $medicine=Medicine::find($id);
        $medicine->delete();
        return response()->json(['success'=>'Record has been deleted']);
    }

    public function deleteCheckedMedicines(Request $req){
        $ids=$req->ids;
        Medicine::whereIn('id',$ids)->delete();
        return response()->json(['success'=>'Medicines have been deleted!']);
    }

    public function addLaboratoryView(){
        return view('admin.add_laboratoryTech');
    }

    public function indexLaboratory(){
        $laboratorys = Laboratory::orderBy('id','DESC')->get();
        return view('admin.showlaboratorys',['laboratorys'=>$laboratorys]);
    }

    public function addLaboratory(Request $request){
        // dd($request->all());
        $laboratory=new Laboratory;
        $image=$request->file;
        $imagename=time().'.'.$image->getClientoriginalExtension();
        $request->file->move('laboratoryimage',$imagename);
        $laboratory->image=$imagename;
        $laboratory->name=$request->name;
        $laboratory->email=$request->email;
        $laboratory->password=Hash::make($request->password);
        $laboratory->save();
        return response()->json
        ([
            'message' => 'Laboratory Technician was successfully added',
            'laboratory' => $laboratory
       ]);
    }

    public function getLaboratory(){
        $laboratorys=Laboratory::all();
        return response()->json($laboratorys);
    }

    public function getLaboratoryById($id){
        $laboratory=Laboratory::find($id);
        return response()->json($laboratory);
    }

    public function updateLaboratory(Request $request){
        // dd($request->all());
        $laboratory=Laboratory::find($request->id);
        if($request->file){
            $image=$request->file;
            $imagename=time().'.'.$image->getClientoriginalExtension();
            $request->file->move('laboratoryimage',$imagename);
            $laboratory->image=$imagename;
        }
        $laboratory->name=$request->name;
        $laboratory->email=$request->email;
        // $laboratory->password=$request->password;
        // $laboratory->password=Hash::make($request->password);
        $laboratory->save();
        return response()->json($laboratory);
    }

    public function deleteLaboratory($id){
        $laboratory=Laboratory::find($id);
        $laboratory->delete();
        return response()->json(['success'=>'Record has been deleted']);
    }

    public function deleteCheckedlaboratorys(Request $req){
        $ids=$req->ids;
        Laboratory::whereIn('id',$ids)->delete();
        return response()->json(['success'=>'Laboratory Technicians have been deleted!']);
    }

    public function showforgetForm(){
        return view('admin.password.forget');
    }

    public function sendResetLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:admins,email'
        ]);
        $token=\Str::random(64);
        \DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
        ]);
        $action_link=route('admin.resetFormShow',['token'=>$token,'email'=>$request->email]);
        $body="We have received a request to reset the password <b>Hospital Management System</b> account associated with ".$request->email.".You can reset your password by clicking the link below.";
        \Mail::send('layouts\email-forget',['action_link'=>$action_link,'body'=>$body],function($message) use ($request){
            $message->from('noreply@example.com','Hospital Management System');
            $message->to($request->email,'Admin Name')
            ->subject('Reset Password');
        });
        return back()->with('success','We have e-mailed your password reset link');
    }
    public function showResetForm(Request $request,$token=null){
        return view('admin.password.reset')->with(['token'=>$token,'email'=>$request->email]);
    }
    public function resetPassword(Request $request){
        $request->validate([
            'email'=>'required|email|exists:admins,email',
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
            \App\Models\Admin::where('email', $request->email)->update([
               'password'=>\Hash::make($request->password)
           ]);

           \DB::table('password_resets')->where([
               'email'=>$request->email
           ])->delete();

           return redirect()->route('admin.login')->with('info', 'Your password has been changed! You can login with new password')->with('verifiedEmail', $request->email);
       }
    }
}
