<?php

namespace App\Http\Middleware;

use Closure;
use App\Group;
use Illuminate\Contracts\View\Factory as ViewFactory;


class Common
{

    /**
     * The view factory implementation.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * Create a new error binder instance.
     *
     * @param  \Illuminate\Contracts\View\Factory  $view
     * @return void
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        return $next($request);
    }

    // public function terminate($request, $response)
    // {
        
    //     // // $shopping_groups = session('cart_items') ? Group::find(session('cart_items')) : [];
        
    //     // // session()->put('shopping_groups', $shopping_groups);
    //     // $this->view->share(
    //     //     'shopping_groups', $request->session()->get('cart_items') ? Group::find($request->session()->get('cart_items')) : []
    //     // );

    //     // dd(session()->all());
    // }
}
