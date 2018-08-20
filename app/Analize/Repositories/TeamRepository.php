<?php 

namespace App\Analize\Repositories;

use App\Team;


class TeamRepository{

    protected $team;


    public function __construct(Team $team){
        $this->team = $team;
    }

    public function  create($columns, $lab){
        extract($columns); 
        
        $team  = Team::create([
            'name' => $name,
            'title' => $title,
            'rank' => $rank,
            'lab_id' => $lab_id
        ]);

        $path = $this->uploadAvatar($avatar, $team->id, $lab);

        if($path){
            $team->avatar = $path;
            $team->save();
        }


        return $team;
        
        
    }

    private function uploadAvatar($avatar, $team_id, $lab){
        
        $path = '';

        if(is_uploaded_file($avatar) && $avatar->isValid()) {

            $path = $avatar->storeAs('public/teams', $lab->slug . '-member-' . $team_id . '.' . $avatar->extension());   
        }

        return $path;
        
    }


}