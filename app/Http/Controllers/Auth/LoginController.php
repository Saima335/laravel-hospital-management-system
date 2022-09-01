<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    // protected $redirectTo = '/patient/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest',['except'=>['logout','userLogout']]);
        $this->middleware('guest:patient')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:laboratory')->except('logout');
        $this->middleware('guest:doctor')->except('logout');
    }

    public function userLogout(){
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    // public function authenticatePatient(Request $request){
    //     $this->validate($request,[
    //         'email'=>'required|email',
    //         'password'=>'required'
    //     ]);

    //     if(Auth::guard('patient')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
    //         return redirect()->route('home');
    //     }
    //     else{
    //         session()->flash('error','Either Email/Password is incorrect');
    //         return back()->withInput($request->only('email'));
    //     }
    // }

    // public function authenticateAdmin(Request $request){
    //     $this->validate($request,[
    //         'email'=>'required|email',
    //         'password'=>'required'
    //     ]);

    //     if(Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
    //         return redirect()->route('admin.dashboard');
    //     }
    //     else{
    //         session()->flash('error','Either Email/Password is incorrect');
    //         return back()->withInput($request->only('email'));
    //     }
    // }

    // public function authenticateDoctor(Request $request){
    //     $this->validate($request,[
    //         'email'=>'required|email',
    //         'password'=>'required'
    //     ]);

    //     if(Auth::guard('doctor')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
    //         return redirect()->route('doctor.dashboard');
    //     }
    //     else{
    //         session()->flash('error','Either Email/Password is incorrect');
    //         return back()->withInput($request->only('email'));
    //     }
    // }

    // public function authenticateLaboratory(Request $request){
    //     $this->validate($request,[
    //         'email'=>'required|email',
    //         'password'=>'required'
    //     ]);

    //     if(Auth::guard('laboratory')->attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
    //         return redirect()->route('laboratory.dashboard');
    //     }
    //     else{
    //         session()->flash('error','Either Email/Password is incorrect');
    //         return back()->withInput($request->only('email'));
    //     }
    // }
}
