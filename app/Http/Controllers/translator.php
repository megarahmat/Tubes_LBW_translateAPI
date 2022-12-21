<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class translator extends Controller
{
    public  function getLanguage(){
        Cache::remember('api-text-translate', 60*60*24, function(){
            $response = Http::withHeaders([
                "X-RapidAPI-Host" =>"text-translator2.p.rapidapi.com",
		        "X-RapidAPI-Key"=>"14b8131dedmsh351438d59075631p17c00bjsnd36b7a1b73a0",
            ])->get('https://text-translator2.p.rapidapi.com/getLanguages', []);
            return $response->json('data.languages');
        });
        $lang = Cache::get('api-text-translate');
        $languanges = array();   
        for($i = 0; $i<count($lang);$i++){
            $languanges[$i] = array(
                'code' => $lang[$i]['code'],
                'name' => $lang[$i]['name']
            );
        }

        return view('home',['title'=>'Home','bahasa' => $languanges]);

        
    }

    public function translate(Request $inputText){
        
        $response = Http::withHeaders([
            "X-RapidAPI-Host"=>" text-translator2.p.rapidapi.com",
            "X-RapidAPI-Key"=>" 14b8131dedmsh351438d59075631p17c00bjsnd36b7a1b73a0",
            "content-type"=>" application/x-www-form-urlencoded"
        ])->post('https://text-translator2.p.rapidapi.com/translate', [
            "source_language" => $inputText->input_bahasa,
            "target_language" => $inputText->target_bahasa,
            "text"=> $inputText->input_text
        ]);

        dd($response->json());
    }

}
