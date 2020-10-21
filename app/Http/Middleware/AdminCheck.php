<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminCheck
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
        if($request->path() == 'app/admin_login'){

            return $next($request);
        }
        Log::info('inside middleware');
        if(!Auth::check()){
            return response()->json([
                'msg'=> 'you are not authorized user'
            ]);
        }else{

            return $next($request);
        }
    }
}
