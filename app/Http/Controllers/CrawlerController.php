<?php

namespace App\Http\Controllers;

use App\Synevo;

use App\Synlab;
use App\Medlife;
use Goutte\Client;
use App\Reginamaria;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;

class CrawlerController extends Controller
{
   
    public function synevo(){

        // https://www.synevo.ro/category/servicii-si-tarife/

        $items = [];

        $base_url = "https://www.synevo.ro/category/servicii-si-tarife/";
        
        $goutteClient = new Client();
        
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
            'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ),
        ));

        $goutteClient->setClient($guzzleClient);

        $crawler = $goutteClient->request('GET', $base_url);

        $pages_count =  get_number_of_synevo_pages($crawler);

        $external_links =  get_external_link_on_synevo_page($crawler);
        
        $page_items = get_items_on_synevo_page($crawler);

        

        $items = array_merge($items, $page_items);

        for($page = 2; $page<=$pages_count; $page++){
        
            $url = $base_url . '/page/' . $page . '/';

            $p_crawler = $goutteClient->request('GET', $url);
            
            $page_items = get_items_on_synevo_page($p_crawler);

            $external_links =  array_merge($external_links, get_external_link_on_synevo_page($p_crawler));

            $items = array_merge($items, $page_items);

        }

        if(count($external_links) > 0){

            foreach($external_links as $url){

                // echo $url;

                $crawler = $goutteClient->request('GET', $url);

                $pages_count =  get_number_of_synevo_pages($crawler);

                $external_links =  get_external_link_on_synevo_page($crawler);
                
                $page_items = get_items_on_synevo_page($crawler);

                // echo ' - count: ' . count($page_items) . '<br>';

                $items = array_merge($items, $page_items);

                for($page = 2; $page<=$pages_count; $page++){
                
                    $page_url = $url . '/page/' . $page . '/';

                    $crawler = $goutteClient->request('GET', $page_url);
                    
                    $page_items = get_items_on_synevo_page($crawler);
                    
                    // echo $url . ' - Page: ' . $page . ' count ' . count($page_items) . '<hr>';

                    $items = array_merge($items, $page_items);

                }

            }
        }

        foreach($items as $item){

            if($item['price'] !== 0){
                
                $synevo = Synevo::firstOrNew([
                    'scraped_name' => $item['name'],
                ]);
                
                $synevo->name = $item['name'];
                $synevo->code = $item['code'];
                $synevo->price = $item['price'];
                $synevo->s_scraped = 1;
    
                $synevo->save();
    
            }
            
        }
       
        return back()->with('status', 'done getting synevos data');
        
    }
    public function synlab(){

        // http://www.synlab.ro/ro/home/servicii/servicii/analize-romania/hematologie/

        $items = [];

        $base_url = "http://www.synlab.ro/ro/home/servicii/servicii/analize-romania/";
        
        $goutteClient = new Client();
        
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
            'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ),
        ));

        $goutteClient->setClient($guzzleClient);

        $crawler = $goutteClient->request('GET', $base_url);

        $links = get_all_synlab_links($crawler);
        
        // dd($links);
        foreach($links as $link){
            
            $link = 'http://www.synlab.ro/' . $link;
            
            // dd($link);
            $crawler = $goutteClient->request('GET', $link);

            $page_items = get_items_on_synlab_page($crawler);
        
            $items = array_merge($items, $page_items);
        }

        // dd($items);
        foreach($items as $item){

            if($item[2] > 0){
                
                $synlab = Synlab::firstOrNew([
                    'scraped_name' => trim($item[1]),
                ]);
    
                $synlab->name = trim($item[1]);
                $synlab->code = trim($item[0]);
                $synlab->price = (float) trim($item[2]);
                $synlab->is_scraped = 1;
    
                $synlab->save();
    
            }
            
        }
       
        return back()->with('status', 'done getting synlab data');
        
    }
    public function reginamaria(){
        // https://www.reginamaria.ro/laborator/gama-de-analize

        $items = [];

        $base_url = "https://www.reginamaria.ro/laborator/gama-de-analize";
        
        $goutteClient = new Client();
        
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
            'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ),
        ));

        $goutteClient->setClient($guzzleClient);

        $crawler = $goutteClient->request('GET', $base_url);

        $items = get_items_on_reginamaria_page($crawler);


        foreach($items as $item){

            if($item[1] > 0 && !str_is("Nume", $item[0])){

                $reginamaria = Reginamaria::firstOrNew([
                    'scraped_name' => trim($item[0]),
                ]);
    
                
                $reginamaria->name = trim($item[0]);
                $reginamaria->price = (float) trim($item[1]);
                $reginamaria->is_scraped = 1;
    
                $reginamaria->save();
    
            }
            
        }
       
        return back()->with('status', 'Done getting reginamarias data');
        
         
        
    }
    public function medlife(){
        // https://www.medlife.ro/servicii-laborator?field_shortname_tid=253

        $items = [];

        $base_url = "https://www.medlife.ro/servicii-laborator";
        $base_url = "https://www.medlife.ro/servicii-laborator?field_shortname_tid=253";
        
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
            'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ),
        ));
   
        $client = new GuzzleClient(['base_uri' => 'https://www.medlife.ro/']);
        
        $response = $client->request('GET', 'servicii-laborator?field_shortname_tid=253');

        $contents = $response->getBody()->getContents();
        
        preg_match_all("'<tr class=\"labs-servicii\">(.*?)</tr>'si", $contents, $matches);

        $records = $matches[1];

        foreach($records as $record){

            $record_data = trim($record);
            
            $record_data = explode('</td>',$record_data);
            
            $name  = trim($record_data[0]); //get name
            $price = trim($record_data[2]); // get price
            
            $name  = str_replace('<td class="labs-s-title">', '', $name);
            $price = str_replace('<td class="labs-s-price">', '', $price);
            $price = str_replace(' RON', '', $price);

            $items = array_prepend($items, [$name, $price]);
        }

        

         foreach($items as $item){

            if($item[1] > 0 ){

                $medlife = Medlife::firstOrNew([
                    'scraped_name' => trim($item[0]),
                ]);
    
                
                $medlife->name = trim($item[0]);
                $medlife->price = (float) trim($item[1]);
                $medlife->is_scraped = 1;    
                $medlife->save();
    
            }
            
        }
        
        return back()->with('status', 'Done getting Medlife data');
                
    }
   
}
