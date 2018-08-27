<?php 

namespace App\Analize\Repositories;

use App\Lab;
use App\User;


class UserRepository{

    protected $user;


    public function __construct(User $user){
        $this->user = $user;
    }

    public function all(){
        return User::paginate(20);
    }

    public function assignLab($user,  $lab_id){
        
        $lab = Lab::find($lab_id);

        $lab->user_id = $user->id;
        $lab->confirmed = 1;

        $lab->save();
        return $this->user;
    }
    
    public function approveLab($lab){
        
        $lab->confirmed = 1;
        $lab->save();
        return $lab;
    }
    
    public function unapproveLab($lab){
        
        $lab->confirmed = 0;
        $lab->save();
        return $lab;
    }

    public function unassignLab($user){
        
        if($user->lab){
            $lab = $this->unapproveLab($user->lab);
            $lab->user_id = null;
            $lab->save();
        }
        

        return $user;
    }

    public function delete($user){
        
        if($user->lab){
            $this->unassignLab($user->lab);
        }
        
        if(!$user->isAdmin) 
        {
            return $user->delete();
        }else{
            return $user;
        }
    }




}