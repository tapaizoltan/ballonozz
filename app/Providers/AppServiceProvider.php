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
                $hibasak = 0;
                foreach (Coupon::all() as $coupon) 
                {
                    if (!$coupon->isActive) 
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
        
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            fn (): string => Blade::render('@vite([\'resources/css/checking.css\'])'),
        );
    }
}
