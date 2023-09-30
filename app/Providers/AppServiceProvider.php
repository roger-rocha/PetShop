<?php

namespace App\Providers;

use Filament\Forms\Components\DatePicker;
use Illuminate\Support\ServiceProvider;

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
        DatePicker::configureUsing(function (DatePicker $datePicker): void {
            $datePicker->displayFormat('d/m/Y');
            $datePicker->native(false);
            $datePicker->firstDayOfWeek(7);
        });
    }
}
