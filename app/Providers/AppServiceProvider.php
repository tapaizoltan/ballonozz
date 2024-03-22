<?php

namespace App\Providers;

use App\Models\Coupon;
use App\Enums\CouponStatus;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Filament\Notifications\Notification;
use Filament\Support\Facades\FilamentView;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            function()
            {
                $coupons = Coupon::query()->with(['passengers'])->whereIn('status', [CouponStatus::CanBeUsed, CouponStatus::Gift])->get();
                //dd($coupons);
                $hibasak = 0;
                foreach ($coupons as $coupon) 
                {
                    $all_passengers_of_coupon = $coupon->adult + $coupon->children;
                    $kitoltott = $coupon->passengers->count();
                    if ($all_passengers_of_coupon != $kitoltott)
                    {
                        $hibasak++;
                    }
                }
                if($hibasak>0)
                {
                    Notification::make()
                    ->title('Hiányzó utas(ok)')
                    ->success()
                    ->persistent()
                    ->send();
                }
                //die;
            },
        );

    }
}
