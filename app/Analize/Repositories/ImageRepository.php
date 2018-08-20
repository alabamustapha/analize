<?php 

namespace App\Analize\Repositories;

use App\Image;


class ImageRepository{

    protected $team;


    public function __construct(Image $image){
        $this->image = $image;
    }

    public function  create($columns, $lab){
        

        extract($columns); 
        

        $image  = Image::create([
            'title' => $title,
            'rank' => $rank,
            'description' => $description,
            'lab_id' => $lab_id
        ]);

        $path = $this->uploadImage($gallery_image, $image->id, $lab);

        if($path){
            $image->url = $path;
            $image->save();
        }


        return $image;
        
        
    }

    private function uploadImage($image, $image_id, $lab){
        
        $path = '';
        if(is_uploaded_file($image) && $image->isValid()) {
            $path = $image->storeAs('public/gallery', $lab->slug . '-image-' . $image_id . '.' . $image->extension());   
        }

        return $path;
        
    }


}