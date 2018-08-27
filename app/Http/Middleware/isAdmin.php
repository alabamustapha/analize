<?php


namespace App\Http\Middleware;

use App\Lab;
use Closure;

class isAdmin
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
        
        
        if(auth()->check()){
            
            if(is_object($request->route()->parameter('lab'))){
                $lab = $request->route()->parameter('lab');
            }else{
                $lab = Lab::whereSlug($request->route()->parameter('lab'))->first();
            }
            
            


            
            $is_owner = $request->method() != "GET" && optional($lab)->user_id == auth()->user()->id;
        
            if(auth()->user()->isAdmin || $is_owner){
                return $next($request);
            }
        }
        
        return redirect('/');
    }
}
