<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function hasRole($role){
        
        return in_array($role, $this->roles->pluck('name')->toArray());
    }

    public function getIsAdminAttribute(){
        return $this->hasRole('admin');
    }

    public function addRole($role){
        
        $role = Role::where('name', $role)->first();
        
        if($role){
            return $this->roles()->attach($role);
        }else{
            return $this;
        }
        
    }

    public function lab(){
        return $this->hasOne('App\Lab');
    }

    public function getDashboardAttribute(){
        $url = 'user/create_lab';

        if($this->isAdmin) {
          $url =  route('group_index');
        }elseif($this->lab){
            $url = route('user_show_lab_tests', ['lab' => $this->lab->slug]);
        } 

        return $url;
    }


}
