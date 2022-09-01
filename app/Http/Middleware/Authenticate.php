<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
        if (! $request->expectsJson()) {
            if (Route::is('admin.*')){
                return route('admin.login');
            }
            if (Route::is('doctor.*')){
                return route('doctor.login');
            }
            if (Route::is('laboratory.*')){
                return route('laboratory.login');
            }
            if (Route::is('patient.*')){
                return route('patient.login');
            }
            // if (Route::is('patient.*')){
            //     return route('login');
            // }
            return route('login');
        }
    }

    protected function authenticate($request, array $guards){
        // if($this->auth->guard('web')->check()){
        //     return $this->auth->shouldUse('web');
        // }
        // $this->unauthenticated($request,['web']);

        foreach($guards as $guard){    
            switch($guard){
                case "admin":
                    if(Auth::guard($guard)->check()){
                        return $this->auth->shouldUse('admin');
                    }
                    $this->unauthenticated($request,['admin']);
                    break;
                case "doctor":
                    if(Auth::guard($guard)->check()){
                        return $this->auth->shouldUse('doctor');
                    }
                    $this->unauthenticated($request,['doctor']);
                    break;
                case "laboratory":
                    if(Auth::guard($guard)->check()){
                        return $this->auth->shouldUse('laboratory');
                    }
                    $this->unauthenticated($request,['laboratory']);
                    break;
                case "patient":
                    if(Auth::guard($guard)->check()){
                        return $this->auth->shouldUse('patient');
                    }
                    $this->unauthenticated($request,['patient']);
                    break;
                // case "web":
                //     if(Auth::guard($guard)->check()){
                //         return $this->auth->shouldUse('web');
                //     }
                //     $this->unauthenticated($request,['web']);
                //     break;
                default:
                    if(Auth::check()){
                        return $this->auth->shouldUse('web');
                    }
                    $this->unauthenticated($request,['web']);
                    break;
            }
        }
    }
}
