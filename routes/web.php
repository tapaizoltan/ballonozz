<?php

use App\Livewire\Home;
use App\Models\Aircraft;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponsController;
use Filament\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', Home::class);

Route::get('/test', function(){
    //dump(env('AIRCRAFT_PASSENGER_LIMIT', 30));
    //dd(Aircraft::flyable(3, false, false));

    //dump(Http::get("https://ballonozz.hu/wp-json/wc/v3/orders/1541"));

    //dd(Http::withBasicAuth('ck_2f380bdd989588e272cd87603c1c8551a7a999b6', 'cs_7f6ed0ae386d5c5b0deb6fbacb41bcabd9ca9bdc')->get("https://ballonozz.hu/wp-json/wc/v3/orders/1541"));

        $response = Http::withBasicAuth(env('BALLONOZZ_API_USER_KEY'), env('BALLONOZZ_API_SECRET_KEY'))
        
        /*->withUrlParameters([
            'endpoint' => 'https://ballonozz.hu',
            'page' => 'wp-json',
            'sub' => 'wc',
            'version' => 'v3',
            'topic' => 'orders',
            'id' => '1503',
            ])
            //->get('{+endpoint}/{page}/{sub}/{version}/{topic}/{id}')*/
            ->get('https://ballonozz.hu/wp-json/wc/v3/orders/'.'1567');
    
            if ($response->successful())
                {
                    $res = $response->json();
                    foreach($res['line_items'] as $item) {
                        dump($item['product_id'], $item['quantity']);
                    }
                    return;
                    dd($response->json()['line_items'][0]['product_id']);
                }
});