<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Product;
use App\Http\Resources\Product as ProductResource;

class ServiceController extends Controller
{
   
    public function recommend($city){

        if(is_string($city))
        {
            $query = 'https://api.meteo.lt/v1/places/' . $city . '/forecasts/long-term';
            $response = Http::get($query);
            

            $currentDate = date("Y-m-d H:00:00");

            for($i = 0; $i < sizeof($response['forecastTimestamps']); $i++){
                if($response['forecastTimestamps'][$i]['forecastTimeUtc'] == $currentDate){
                    $currentCondition = $response['forecastTimestamps'][$i]['conditionCode'];
                    
                    $products = Product::all()->where('condition', $currentCondition)->take(4);
                    
                    foreach($products as $product){
                        $productsArray[] = array(
                            'sku' => $product['sku'],
                            'name' => $product['name'],
                            'price' => $product['price']
                        );
                    }
                    $response = array(
                        'city' => $city,
                        'current_weather' => $currentCondition,
                        'recommended_products' => $productsArray,
                        'duomenys_is' => 'https://api.meteo.lt/'
                    );
                    
                    $response = json_encode($response);

                    return $response;
                }
            }


        }


        else
        {
            return response('404 not found', 404);
        }
    }
}
