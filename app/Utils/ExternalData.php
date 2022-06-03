<?php

namespace App\Utils;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Character;
use App\Http\Requests\StoreCharacterRequest;
use App\Http\Requests\UpdateCharacterRequest;

class ExternalData
{
    protected $BREAKING_BAD_API_URL = "https://www.breakingbadapi.com/api/characters";

    public function retrieveData(Request $request){
        $response = Http::get($this->BREAKING_BAD_API_URL, ['name' => $request->name]);
        $requestData = $request->all();
        if($response->successful()){
            $charactersArray = $response->json($key = null);
            if(is_array($charactersArray) && !empty($charactersArray)){
                $firstResult = $response[0];
                          
                $requestData["name"] = $firstResult['name'];
                $requestData = array_merge($requestData, ['nickname' => $firstResult['nickname'], 'img' => $firstResult['img'], 'category' => $firstResult['category']]);
            }else{
                $requestData = array_merge($requestData, ['nickname' => "No hay datos", 'img' => "No hay datos", 'category' => "No hay datos"]);
            }
            
        }

        return $requestData;
    }
}
