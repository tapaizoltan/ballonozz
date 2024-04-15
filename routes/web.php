<?php

use App\Livewire\Home;
use App\Models\Aircraft;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponsController;
use App\Models\Tickettype;
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

        $response_coupon = Http::withBasicAuth(env('BALLONOZZ_API_USER_KEY'), env('BALLONOZZ_API_SECRET_KEY'))->get('https://ballonozz.hu/wp-json/wc/v3/orders/'.'1567');
        //Felőtt: 1567
        //Családi: 1508
        if ($response_coupon->successful())
        {
            //dd($response_coupon->json());
            $coupons_data = $response_coupon->json();
            foreach($coupons_data['line_items'] as $coupon)
            {
                //dump($item['product_id'], $item['quantity']);
                $response_item_nums = $coupon['quantity']; 
                $response_product_id = $coupon['product_id'];
                
                $response_product_attributes = Http::withBasicAuth(env('BALLONOZZ_API_USER_KEY'), env('BALLONOZZ_API_SECRET_KEY'))->get('https://ballonozz.hu/wp-json/wc/v3/products/'.$response_product_id);
                if ($response_product_attributes->successful())
                {
                    //dd($response_product_attributes->json());
                    $product_attributes = $response_product_attributes->json();
                    dump(($product_attributes['attributes'][0]['options'][0])*1);
                    dump(($product_attributes['attributes'][1]['options'][0])*$response_item_nums);
                    dump(($product_attributes['attributes'][2]['options'][0])*$response_item_nums);

                    /*foreach($product_attributes['attributes'] as $attribute)
                    {
                        //dump($attribute['options'][0]);
                    }*/
                }
            }
        }
});