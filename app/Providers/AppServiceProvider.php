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
                $coupons_not_filled_with_passengers = 0;
                foreach ($coupons as $coupon) 
                {
                    $coupon_total_passenger_nums = $coupon->adult + $coupon->children;
                    $coupon_registered_passeger_nums = $coupon->passengers->count();
                    if ($coupon_total_passenger_nums != $coupon_registered_passeger_nums)
                    {
                        $coupons_not_filled_with_passengers++;
                    }
                }
                if($coupons_not_filled_with_passengers>0)
                {
                    Notification::make()
                    ->title('Hiányzó utasadatok!')
                    ->iconColor('danger')
                    ->color('danger')
                    ->icon('tabler-alert-triangle')
                    ->persistent()
                    ->send();
                }
                //die;
            },
        );

    }
}
