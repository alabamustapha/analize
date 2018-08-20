<?php

namespace App\Http\Controllers;

use App\Lab;
use App\Group;
use App\Synevo;
use App\Synlab;
use App\Medlife;
use App\Category;
use App\Location;
use App\Reginamaria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        // return view('admin.dashboard');

        $categories =  Category::with('groups')->get();
        
        
        if($request->has('category') && $request->category != 0){
            $groups = Group::where('category_id', $request->category)->with('category')->get();
        }else{
            $groups  = Group::with('category')->get();
        }

        

        $groups = $groups->sortBy('name')->groupBy(function ($item, $key) {
            return substr($item['name'], 0, 1);
        });

        $letters = array_keys($groups->toArray());
        
        
        $laboratories = Lab::all();
        
        return view('welcome', compact(['groups', 'categories', 'laboratories', 'letters']));
    }


    public function labs(Request $request){
        
        

        $selected_city = '';
        
        if($request->has('city') && ($request->city !== null || $request->city != 0) ){
        
            $selected_city = $request->city;

            $locations = Location::where('city', $request->city)->pluck('id')->toArray();

            $laboratories = Lab::whereHas('locations', function ($query) use ($request){
                $query->where('city', 'like', $request->city);
            })->get();

        }else{
            $laboratories = Lab::with('locations')->get();
        }

        $cities = Location::whereIn('lab_id', $laboratories->pluck('id')->toArray())->pluck('city')->toArray();
        
        $laboratories = $laboratories->sortBy('name')->groupBy(function ($item, $key) {
            return substr($item['name'], 0, 1);
        });

        $letters = array_keys($laboratories->toArray());

        $cities = array_unique($cities);
        
        return view('labs.list', compact(['laboratories', 'letters', 'cities', 'selected_city']));
    }
}
