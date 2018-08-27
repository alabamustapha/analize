<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Lab extends Model
{
    use Sluggable;
    
    protected $fillable = ['name', 'short_name', 'url', 'slug', 'bio', 'bio_excerpt', 'bio_image', 'user_id'];

    public function locations(){
        return $this->hasMany('App\Location');
    }

     /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(){
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName(){
        return 'slug';
    }


    public function closestTo($address){
        $ranked_distances = get_distances($address, $this->locations()->pluck('address')->toArray());

        if(is_array($ranked_distances)){

            return array_first($ranked_distances);

        }

        return null;
        // return get_distances($address, $this->locations()->pluck('address')->toArray());
    }

    public function tests(){
        return $this->hasMany('App\Test');
    }

    public function getLogoAttribute($value){
        return \Storage::url($value);
    }
    
    public function getBioImageAttribute($value){
        return \Storage::url($value);
    }

    public function teams(){
        return $this->hasMany('App\Team');
    }

    public function packages(){
        return $this->hasMany('App\Package');
    }
    
    public function images(){
        return $this->hasMany('App\Image');
    }

   

}
