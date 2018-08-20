<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Analize\Repositories\UserRepository;


class UserController extends Controller
{
    public $user;

    public function __construct(UserRepository $user){
        $this->user = $user;
    }

    
    
}
