<?php

use App\Http\Controllers\getLanguagesGoogleAPI;
use App\Http\Controllers\translator;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home',[
//         "title" => "Home"
//     ]);
// });

Route::get('/about', function () {
    return view('about',[
        "title" => "About"
    ]);
});

// Route::get('/',[getLanguagesGoogleAPI::class,'index']);

Route::get('/',[translator::class,'getLanguage']);

// Route::post('/getTranslate', [getLanguagesGoogleAPI::class,'translate']);

Route::post('/getTranslate',[translator::class,'postTranslate']);
