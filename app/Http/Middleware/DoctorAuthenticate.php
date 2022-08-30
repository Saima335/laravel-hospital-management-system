<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class DoctorAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('doctor.login');
        }
    }

    protected function authenticate($request, array $guards){
        if($this->auth->guard('doctor')->check()){
            return $this->auth->shouldUse('doctor');
        }
        $this->unauthenticated($request,['doctor']);
    }
}
