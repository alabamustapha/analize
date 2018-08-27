<?php

namespace App\Http\Controllers;

use App\Lab;
use App\Test;
use App\Group;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, Lab $lab)
    {
        $test = Test::create([
            'name' => $request->name,
            'price' => $request->price,
            'lab_id' => $lab->id
        ]);

        return back()->with('message', 'Test added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Lab $lab, Test $test)
    {
        return view('labs.edit_test', compact('lab', 'test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lab $lab, Test $test)
    {
        
        $test->group_id = $request->has('group_id') ? $request->group_id : $test->group_id;
        $test->name = $request->has('name') ? $request->name : $test->name;
        $test->price = $request->has('price') ? $request->price : $test->price;
        $test->save();
        return back()->with('status', $test->name . ' linked');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function updateGroupTest(Request $request, Lab $lab, Group $group)
    {

        $test =  Test::find($request->test_id);
        $test->group_id = $group->id;
        $test->save();
        return back()->with('status', $test->name . ' linked');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}
