<?php

namespace App\Providers;

use App\Models\Coupon;
use App\Enums\CouponStatus;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Filament\Notifications\Notification;
use Illuminate\Support\ServiceProvider;
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
                $coupons_not_filled_with_passengers = 0;
                foreach (Coupon::all() as $coupon) 
                {
                    if (!$coupon->isActive) 
                    {
                        $coupons_not_filled_with_passengers++;
                    }
                }
                if($coupons_not_filled_with_passengers>0)
                {
                    Notification::make()
                    ->title('Hiányzó utasadatok!')
                    ->body('Repülésre történő jelentkezéshez töltse fel elérhető kuponja utasainak adatait.')
                    ->iconColor('danger')
                    ->color('danger')
                    ->icon('tabler-alert-triangle')
                    ->persistent()
                    ->send();
                }
                //die;
            },
        );
        
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            fn (): string => Blade::render('@vite([\'resources/css/checking.css\', \'resources/css/list-checkins.css\'])'),
        );
    }
}
