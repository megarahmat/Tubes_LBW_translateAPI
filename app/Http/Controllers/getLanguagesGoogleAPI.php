<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class getLanguagesGoogleAPI extends Controller
{
    public  function index(){
        Cache::remember('api-google-translate', 60*60*24, function(){
            $response = Http::withHeaders([
                "accept-encoding"=> "application/gzip",
                "x-rapidapi-key"=> "14b8131dedmsh351438d59075631p17c00bjsnd36b7a1b73a0",
                "x-rapidapi-host"=> "google-translate1.p.rapidapi.com",
            ])->get('https://google-translate1.p.rapidapi.com/language/translate/v2/languages', []);
            return $response->json('data.languages');
        });
        $lang = Cache::get('api-google-translate');
        $languanges = array();        
        for($i = 0; $i<count($lang);$i++){
            $languanges[$i] = $lang[$i]['language'];
        }
        return view('home',['title'=>'Home','bahasa' => $languanges]);
    }

    public function translate(Request $inputText){
        
        $response = Http::withHeaders([
            "content-type" => "application/x-www-form-urlencoded",
            "accept-encoding"=> "application/gzip",
            "x-rapidapi-key"=> "14b8131dedmsh351438d59075631p17c00bjsnd36b7a1b73a0",
            "x-rapidapi-host"=> "google-translate1.p.rapidapi.com"
        ])->post('https://google-translate1.p.rapidapi.com/language/translate/v2', [
            "q"=> $inputText->input_text,
            "target" => $inputText->target_bahasa,
            "source" => $inputText->input_bahasa
        ]);

        dd($response->json());
    }


    public function translateBing(Request $inputText){
        $response = Http::withHeaders([
            "X-RapidAPI-Host"=>"microsoft-translator-text.p.rapidapi.com",
            "X-RapidAPI-Key"=>"14b8131dedmsh351438d59075631p17c00bjsnd36b7a1b73a0",
            "content-type"=>"application/json"
        ])->post("https://microsoft-translator-text.p.rapidapi.com/translate?to%5B0%5D=%3CREQUIRED%3E&api-version=3.0&profanityAction=NoAction&textType=plain", [
            "Text" => $inputText->input_text            
        ]);

        dd($response->json());
    }

    
}
