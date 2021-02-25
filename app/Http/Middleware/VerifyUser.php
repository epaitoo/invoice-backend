<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class VerifyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('username')){
            // Get the user if it Exists and continue with the request
            $user = User::where('email', $request->username)->first();
            if($user){
                return $next($request);
            }
        }

        return response('User does not exist', 400);
        
    }
}
