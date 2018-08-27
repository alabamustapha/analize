<?php

namespace App\Http\Controllers;

use App\Lab;
use App\User;
use Illuminate\Http\Request;
use App\Analize\Repositories\UserRepository;


class UserController extends Controller
{
    public $user;

    public function __construct(UserRepository $user){
        $this->user = $user;
    }

    public function index(){
        $users = $this->user->all();
        $labs = Lab::whereNull('user_id')->get();
        return view('users.index', compact('users', 'labs'));
    }

    public function assignLab(Request $request, User $user){
        
        $this->user->assignLab($user, $request->lab_id);
        
        return back()->with('Lab assigned to ' . $user->name . ' and approved');
    }
  
    public function approveLab(Request $request, User $user){
        $this->user->approveLab($user->lab);

        return back()->with('message', $user->name . ' lab approved');
    }
   
    public function unapproveLab(Request $request, User $user){
        $this->user->unapproveLab($user->lab);

        return back()->with('message', $user->name . ' lab unapproved');
    }

    public function unassignLab(Request $request, User $user){
        
        $this->user->unassignLab($user);

        return back()->with('message', 'Lab access revoked');
    }

    public function destroy(User $user){

        $this->user->delete($user);

        return back()->with('message', $user->name . ' deleted');
        
    }

    
    
}
