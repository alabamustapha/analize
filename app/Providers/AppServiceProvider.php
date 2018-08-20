<?php

namespace App\Providers;

use App\Location;


use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Schema::defaultStringLength(191);
        if(Schema::hasTable('locations')){
            $cities = Location::all()->pluck('city')->toArray();
            $cities = array_unique($cities);
            $cities = array_sort($cities);
            View::share('cities', $cities);
        }   
        
        
    
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
