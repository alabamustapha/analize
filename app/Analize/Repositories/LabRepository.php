<?php 

namespace App\Analize\Repositories;

use App\Lab;
use App\Http\Helper\Crawler;


class LabRepository{

    protected $lab;


    public function __construct(Lab $lab){
        $this->lab = $lab;
    }

    public function all($paginate = 15){
        return Lab::paginate($paginate);
    }

    public function create($columns){
        return Lab::create($columns);
    }


    public function scrape($short_name, $lab_id){
        
        $crawler = new Crawler();
        
        $message = '';

        if(method_exists($crawler, $short_name)){
            
            
            try{
                $crawler->$short_name($short_name, $lab_id);
                $message = "Record updated";
            }catch(\Exception $e){
                
                $message = 'Some data might not be have been scrapped';
            }
            
        }
        
        return $message;
    }

    public function deleteTest($test){
        try{
            $test->delete();
            $message = 'Test deleted successfully';
        }catch(\Exception $e){
            $message = 'Something went wrong';
        }

        return $message;
    }



}