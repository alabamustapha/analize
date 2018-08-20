<?php

namespace App\Http\Controllers;

use App\Group;
use App\Synevo;
use App\Synlab;
use App\Medlife;
use App\Category;
use App\Reginamaria;
use Illuminate\Http\Request;
use App\Http\Requests\CreateGroupRequest;
use App\Analize\Repositories\GroupRepository;

class GroupController extends Controller
{

    public $group;

    public function __construct(GroupRepository $group){
        $this->middleware('auth');
        $this->group = $group;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $groups =  $this->group->all();
        return view('group.index', compact(['groups']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories =  Category::all();
        return view('group.create', compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGroupRequest $request)
    {
        
        $group = $this->group->create($request->except('_token'));

        return back()->with('status', $group->name . ' added');    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('group.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $categories =  Category::all();
        return view('group.edit', compact(['group', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $group->update($request->all());
        return back()->with('status', $group->name . ' Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return back()->with('status', 'group deleted');
    }

   
}
