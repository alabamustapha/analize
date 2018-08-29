<?php




function isActiveRoute($route_name){
    return str_is($route_name, \Route::currentRouteName());
}

function get_items_on_synevo_page($crawler){
    
    $items = $crawler->filter('ul.lista-analize li.alignleft')->each(function ($node) {
            
        if($node->children()->first()->children()->count() < 2){
            $name = $node->children()->first()->text();
            try{
                $code = $node->children()->first()->children()->first()->text();
            }catch(\InvalidArgumentException $e){
                $code = "N/A";
            }
        }else{
            $name = $node->children()->first()->children()->first()->text();
            
            try{
                $code = $node->children()->first()->children()->siblings()->first()->text();
            }catch(\InvalidArgumentException $e){
                $code = "";
            }
        }
        
        $name = trim($name);
        $code = trim($code);
        
        if(ends_with($name, $code)){
            $name = str_replace_last($code, '', $name);
        }

        if($node->children()->first()->siblings()->first()->children()->count() < 2){
            $price = '0 Lei';
        }else{
            $price = $node->children()->first()->siblings()->first()->children()->first()->text();
        }
        
        if(str_contains($price, 'Lista analize')){
            $price = '0 Lei';
        }
        
        // echo $name . '<br>';    
        // echo $code . '<br>';
        // echo $price . '<hr/>';

        $price = str_replace('Lei', '', $price);

        $price = trim($price);
        return  ['name' => $name, 'code' => $code, 'price' => (int)$price];
        

    });

    return $items;

}

function get_external_link_on_synevo_page($crawler){

    $links = $crawler->filter("div.alignright > strong > a")->each(function($node){
        return array_first($node->extract(array('href')));
    });
    
    return $links;
    
}

function get_number_of_synevo_pages($crawler){
    
    if($crawler->filter('span.pages')->count() > 0){
        $text = $crawler->filter('span.pages')->first()->text();        
        $text_split = explode(' ', $text);
        $last_page = array_pop($text_split);
    }else{
        $last_page = 1;
    }
    

    return $last_page;
}

function get_all_synlab_links($crawler){
    $links = $crawler->filter("ul.csc-menu.csc-menu-1 > li > a")->each(function($node){
        return array_first($node->extract(array('href')));
    });
    
    return $links;
}


function get_items_on_synlab_page($crawler){
    
    $items = $crawler->filter('.contenttable > tbody > tr')->each(function ($node) { 
        
        if($node->children()->count() == 4){

            $id_inv = [$node->children()->first()->siblings()->first()->text()];

            $info = $node->children()->first()->siblings()->first()->nextAll()->each(function ($info_node){
                return $info_node->text();
            });
            
            $info = array_merge($id_inv, $info);

            
            return  $info;

        }else{
            return [];
        }
    });

    array_shift($items);
    array_shift($items);
    return $items;

}


function get_items_on_reginamaria_page($crawler){
    
    $items = [];

    $names = $crawler->filter('span.field_denumire')->each(function ($node) { 
        
        return trim($node->text());

    });
    
    $prices = $crawler->filter('span.field_price')->each(function ($node) { 
        
        return trim($node->text());

    });

    

    for($i = 0; $i<count($names); $i++){


        $item[0] = clean_reginamaria_name($names[$i], $prices[$i]);
        $item[1] = $prices[$i];
        array_push($items, $item);
    }
    // $items = [$names, $prices];

    return $items;

}


function clean_reginamaria_name($name, $price){

    if(str_contains($name, " Add")){
        
        
        $item_name_split = explode('(', $name);
        
        $name = array_shift($item_name_split);

    }

    return $name;
}


function get_items_on_medlife_page($crawler){
    
    $items = [];

    

    dd($crawler->filter("body")->html());
    return $crawler->filter("table.labs-grup > tbody > tr")->count();


    // $names = $crawler->filter('span.field_denumire')->each(function ($node) { 
        
    //     return trim($node->text());

    // });
    
    // $prices = $crawler->filter('tr.labs-servicii')->each(function ($node) { 
        
    //     return trim($node->text());

    // });

    

    // for($i = 0; $i<count($names); $i++){


    //     $item[0] = clean_reginamaria_name($names[$i], $prices[$i]);
    //     $item[1] = $prices[$i];
    //     array_push($items, $item);
    // }
    // $items = [$names, $prices];

    return $items;

}

function get_distances($from, $destinations){
    
    if(empty($destinations)){
        return null;
    }
    
    $distances = [];
    $locations =  $destinations;
    $destinations = implode('|', $destinations);
    
    $distance_response = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $from . "&destinations=". $destinations . "&key=" . "AIzaSyCmao5kEYaSvdBe3XCTNqnBx9wvumSW2WI";
    
    $client = new GuzzleHttp\Client();
    $res = $client->get($distance_response);
    
    
    if($res->getStatusCode() == 200){
        $response = json_decode($res->getBody());
        
        $distance = [];

        $location_index = 0;
        
        foreach($response->rows[0]->elements as $element){
            $distance['location'] = $locations[$location_index];        
            $distance['distance_text'] = $element->distance->text;
            $distance['distance_value'] = $element->distance->value;
            $distance['duration_text'] = $element->duration->text;
            $distance['duration_value'] = $element->duration->value;

            array_push($distances, $distance);
            $location_index++;
        }

    }
    

    $distances = array_values(array_sort($distances, function ($value) {
        return $value['distance_value'];
    }));
    
    return $distances;
}



function closestAddress($distances){
    
        return is_array($distances) ? array_first($ranked_distances) : null;
}


function linkToMap($address){
    return "https://maps.google.com/maps?q=" . urlencode($address);
}