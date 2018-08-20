<?php

namespace App\Http\Controllers;

use App\Lab;
use App\Group;
use App\Location;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function addToCart(Request $request){

        if($request->session()->has('cart_items')){
            $cart_items = $request->session()->get('cart_items');
        }else{
            $cart_items = session()->put('cart_items', [$request->group_id]);
        }
        
        

        if(in_array($request->group_id, $cart_items)){
            $message = 'Product exist in cart';
        }else{
            array_push($cart_items, $request->group_id);
            $message = 'Product added to cart';
            
    
            session()->put('cart_items', $cart_items);
            
            
        }

        $cart_groups = Group::find($cart_items);
        session()->put('cart_groups', $cart_groups);


        if ($request->isMethod('post')){    
            return response()->json(['message' => $message, 'cart_items' => $cart_items, 'cart_groups' => $cart_groups]); 
        }

        return response()->json(['message' => $message, 'cart_items' => $cart_items, 'cart_groups' => $cart_groups ]); 

    }
    
    public function removeFromCart(Request $request){

        if($request->session()->has('cart_items')){
            $cart_items = $request->session()->get('cart_items');

            if(in_array($request->group_id, $cart_items)){
                
                $cart_items = array_where($cart_items, function ($value, $key) use ($request){
                    return $value != $request->group_id;
                });

                $message = 'Product removed from cart';
            }else{
                
                $message = 'Product not in cart';
            
            }
        }else{
            $cart_items = [$request->group_id];
        }
        
        session()->put('cart_items', $cart_items);
        $cart_groups = Group::find($cart_items);
        session()->put('cart_groups', $cart_groups);


        if ($request->isMethod('post')){    
            return response()->json(['message' => $message, 'cart_items' => $cart_items, 'cart_groups' => $cart_groups]); 
        }

        return response()->json(['message' => $message, 'cart_items' => $cart_items, 'cart_groups' => $cart_groups ]); 

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $groups_ids = $request->session()->get('cart_items');
        
        $city   = $request->city;

    
        $labs = Lab::with(['tests' => function ($query) use($groups_ids) {
                        $query->whereIn('group_id', $groups_ids);
                    }, 'locations' => function ($query) use($city) {
                        $query->where('city', $city);
                    }])->whereHas('locations', function ($query) use($city) {
                        $query->where('city', $city);
                    })->get();
        
        $groups = Group::find($groups_ids);
        // $grouped_tests = $labs->first()->tests->groupBy('group_id');
        
        
        return view('cart', compact('labs', 'groups', 'city'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
