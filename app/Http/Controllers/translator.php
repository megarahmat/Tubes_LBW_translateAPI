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


    public function postTranslate(Request $inputText){
        
        //post translate text translator
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://text-translator2.p.rapidapi.com/translate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "source_language=$inputText->input_bahasa&target_language=$inputText->target_bahasa&text=$inputText->input_text",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: text-translator2.p.rapidapi.com",
                "X-RapidAPI-Key: 14b8131dedmsh351438d59075631p17c00bjsnd36b7a1b73a0",
                "content-type: application/x-www-form-urlencoded"
            ],
        ]);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);

        $response = curl_exec($curl);
        $data = json_decode($response,true);
        curl_error($curl);

        $bahasa = Cache::get('api-text-translate');

        //post translate google api

        $curlGoogle = curl_init();

        curl_setopt_array($curlGoogle,[


        ]);
        




        return view('home',[
            'title'=>'Home',
            'translatedText' => $data['data']['translatedText'],
            'bahasa' => $bahasa
        ]);        
    }

    

}
