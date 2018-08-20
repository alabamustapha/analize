<?php 

namespace App\Analize\Repositories;

use App\Group;


class GroupRepository{

    protected $group;


    public function __construct(Group $group){
        $this->group = $group;
    }

    public function all($paginate = 15){
        return Group::paginate($paginate);
    }

    public function create($columns){
        return Group::create($columns);
    }



}