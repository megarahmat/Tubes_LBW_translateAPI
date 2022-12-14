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

        curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);//untuk mengatur kembalian curl menjadi string 

        $response = curl_exec($curl);
        $data = json_decode($response,true);//mengubah string menjadi array
        curl_error($curl);
        curl_close($curl);

        

        //post translate google api

        $apiKey = 'AIzaSyAxru-5Xqi-i7Q3ZRkFqIaoHwmTFRL_8YQ';
        $text = $inputText->input_text;
        $source=$inputText->input_bahasa;
        $target=$inputText->target_bahasa;
        $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text) . '&source=' . rawurlencode($source) . '&target=' . rawurlencode($target);

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true); //untuk mengatur kembalian curl menjadi string
        $responseGoogle = curl_exec($handle);                 
        $responseGoogleDecoded = json_decode($responseGoogle, true);//mengubah string menjadi array
        curl_close($handle);

        //method get laguage google

        // $apiKey = 'AIzaSyAxru-5Xqi-i7Q3ZRkFqIaoHwmTFRL_8YQ';
        // $url = 'https://www.googleapis.com/language/translate/v2/languages?key=' . $apiKey;

        // $handle = curl_init($url);
        // curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        // $testResponse = curl_exec($handle);                         
        // curl_close($handle);

        // $testData=json_decode($testResponse,true);
        // dd($testData);


        // MyMemoryAPI
        $curlM = curl_init();

        curl_setopt_array($curlM, [
	    CURLOPT_URL => 'https://translated-mymemory---translation-memory.p.rapidapi.com/get?langpair='.$inputText->input_bahasa.'%7C'.$inputText->target_bahasa .'&q='. $inputText->input_text .'&mt=1&onlyprivate=0&de=a%40b.c',
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_FOLLOWLOCATION => true,
	    CURLOPT_ENCODING => "",
	    CURLOPT_MAXREDIRS => 10,
	    CURLOPT_TIMEOUT => 30,
	    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    CURLOPT_CUSTOMREQUEST => "GET",
	    CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: translated-mymemory---translation-memory.p.rapidapi.com",
                "X-RapidAPI-Key: 164c71065amshbaf5e897770d153p1ed023jsn141616eedc5b"
            ],
        ]);

        $responseM = curl_exec($curlM);
        $errM = curl_error($curlM);

        curl_close($curlM);

	    $hasilTranslate = json_decode($responseM, true);//mengubah string menjadi array
        // dd ($data);
        $bahasa = Cache::get('api-text-translate');

        return view('home',[
            'title'=>'Home',
            'translatedText' => $data['data']['translatedText'],
            'translatedTextGoogle' => $responseGoogleDecoded['data']['translations'][0]['translatedText'],
            'translatedMyMemory' => $hasilTranslate['responseData']['translatedText'],
            'bahasa' => $bahasa
        ]);        
    }

    

}
