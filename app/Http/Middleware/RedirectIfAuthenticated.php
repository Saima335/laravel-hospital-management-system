<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // if (Auth::guard('web')->check()) {
        //     return redirect()->route('home');
        // }
        foreach($guards as $guard){
            if(Auth::guard($guard)->check()){
                switch($guard){
                    case "admin":
                        return redirect()->route('admin.dashboard');
                        break;
                    case "doctor":
                        return redirect()->route('doctor.dashboard');
                        break;
                    case "laboratory":
                        return redirect()->route('laboratory.dashboard');
                        break;
                    case "patient":
                        return redirect()->route('patient.dashboard');
                        break;
                    // case "web":
                    //     return redirect()->route('home');
                    //     break;
                    default:
                        return redirect()->route('home');
                        break;
                }
            }
        }

        return $next($request);
    }
}
