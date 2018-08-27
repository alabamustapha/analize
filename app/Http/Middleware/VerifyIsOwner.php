<?php

namespace App\Http\Middleware;

use App\Lab;
use Closure;

class VerifyIsOwner
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
        $lab = $request->route()->parameter('lab');
        $message = "You do not have the permission to view this page";
        if($lab->user_id == auth()->user()->id && $lab->confirmed){
            return $next($request);
        }

        if($lab->confirmed){
            $message = "Account yet to be confirmed";
        }

        return redirect('/')->with('message', $message);
    }
}
