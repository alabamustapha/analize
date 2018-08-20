<?php 

namespace App\Analize\Repositories;

use App\User;


class UserRepository{

    protected $user;


    public function __construct(User $user){
        $this->user = $user;
    }


}