<?php

namespace App\Http\Controllers;

use App\Lab;
use App\Team;
use App\Test;
use App\Group;
use App\Package;
use App\Http\Helper\Crawler;
use Illuminate\Http\Request;
use App\Http\Requests\CreateLabRequest;
use App\Analize\Repositories\LabRepository;
use App\Analize\Repositories\TeamRepository;
use App\Analize\Repositories\ImageRepository;

class LabController extends Controller
{

    public $lab;
    public $team;
    public $image;

    public function __construct(LabRepository $lab, TeamRepository $team, ImageRepository $image){
        $this->lab = $lab;
        $this->team = $team;
        $this->image = $image;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labs = $this->lab->all();

        return view('labs.index', compact(['labs']));
    }

    public function createLab(){
        return view('labs.create_lab');
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
    public function store(CreateLabRequest $request)
    {
        $lab = $this->lab->create($request->all());
        return back()->with('status', $lab->name . ' added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function show(Lab $lab)
    {
        $tests = $lab->tests()->paginate(15);
        return view('labs.show', compact('lab', 'tests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function edit(Lab $lab)
    {
        return view('labs.edit', compact('lab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lab $lab)
    {
        $lab->update($request->all());
        
        return back()->with('status', $lab->name . ' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lab $lab)
    {
        $lab->delete();
        return back()->with('status', $lab->name . ' Deleted');
    }


    public function scrape(Lab $lab){

        $message = $this->lab->scrape($lab->short_name, $lab->id);

        return back()->with('status', $message);
    }
    
    public function tests(Lab $lab){
        
        $tests = $lab->tests()->paginate(20);

        return view('labs.tests', compact('lab', 'tests'));
        
    }

    public function deleteTest(Lab $lab, Test $test){
        $message = $this->lab->deleteTest($test);

        return back()->with('status', $message);
    }
    
    public function showLocations(Lab $lab){
        return view('labs.locations', compact('lab'));
    }
    
    public function linkTests(Lab $lab){

        $tests = $lab->tests()->doesntHave('group')->get();
        $group_ids = $lab->tests()->has('group')->pluck('group_id')->toArray();

        $group_ids = array_unique($group_ids);
        
        $groups = Group::whereNotIn('id', $group_ids)->orderBy('name')->get();
        
        return view('labs.link_tests', compact('lab', 'tests', 'groups'));
    }
    
    public function linkedTests(Lab $lab){
        $tests = $lab->tests()->whereHas('group')->paginate(20);
        $groups = Group::all();
        return view('labs.linked_tests', compact('lab', 'tests', 'groups'));
    }

    public function labTestsJson(Lab $lab){
        $tests = $lab->tests()->whereDoesntHave('group')->get(['id', 'name AS text'])->toArray();
        return response()->json($tests); 
    }

    public function page(Lab $lab){
        $teams = $lab->teams()->orderBy('rank')->get();
        
        return view('labs.page', compact('lab', 'teams') );
    }

    public function updateLogo(Request $request, Lab $lab){

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {

            $lab->logo = $request->logo->storeAs('public/logos', $lab->slug . '.' . $request->logo->extension());
            
            $lab->save();
            
            $message = 'logo updated';
        }else{
            $message = 'something went wrong.';
        }
        
        return back()->with('logo_status', $message);
    
    }

    public function editBio(Lab $lab){
        return view('labs.edit_bio', compact('lab'));
    }

    public function updateBio(Request $request, Lab $lab){
        $lab->update($request->only(['bio_excerpt', 'bio']));

        return back()->with('message', 'bio updated');
    }

    public function updateBioImage(Request $request, Lab $lab){

        
         if ($request->hasFile('bio_image') && $request->file('bio_image')->isValid()) {

            $lab->bio_image = $request->bio_image->storeAs('public/bio_images', $lab->slug . '.' . $request->bio_image->extension());
            
            $lab->save();
            
            $message = 'bio image updated';
        }else{
            $message = 'something went wrong.';
        }
        
        return back()->with('bio_image_status', $message);
    }

    public function teams(Lab $lab){
        
        return view('labs.teams', compact('lab'));
    }

    public function addTeam(Request $request, Lab $lab){
        $team = $this->team->create($request->all(), $lab);
        return back()->with('status', 'created');
    }

    public function packages(Lab $lab){
        $groups   = Group::orderBy('name')->get();
        $packages = $lab->packages;
        
        return view('labs.packages', compact('lab', 'groups', 'packages'));
    }
    
    public function editPackage(Lab $lab, Package $package){
        
        $groups   = Group::orderBy('name')->get();

        $selected_group = $package->groups->pluck('group_id')->toArray();

        $selected_group = array_unique($selected_group);
        
        return view('labs.edit_package', compact('lab', 'groups', 'package', 'selected_group'));
    }

    public function storePackage(Request $request, Lab $lab){
        $package = Package::create([
            'name' => $request->name,
            'groups' => $request->groups,
            'price' => $request->price,
            'lab_id' => $lab->id
        ]);
        
        return back()->with('status', $package->name . ' package added');
    }

    public function deletePackage(Request $request, Lab $lab, Package $package){

        $package->delete();

        return back()->with('status', 'Deleted');
    }
    
    public function updatePackage(Request $request, Lab $lab, Package $package){

        $package->update($request->all());

        return back()->with('status', 'Updated');
    }

    public function gallery(Lab $lab){
        return view('labs.gallery', compact('lab'));
    }

    public function addGalleryImage(Request $request, Lab $lab){
        $image = $this->image->create($request->all(), $lab);
        return back()->with('status', 'created');
    }

    public function deleteTeam(Lab $lab, Team $team){
        $img_url =  $team->avatar;

        $img_url = str_replace('/storage', '', $img_url);
        
        $team->delete();

        if(\Storage::disk('public')->exists($img_url)){
            \Storage::disk('public')->delete($img_url);
        }
        
        return back()->with('message', 'Deleted');
    }

    
}
