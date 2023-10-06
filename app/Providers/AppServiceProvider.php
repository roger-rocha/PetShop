<?php

namespace App\Providers;

use App\Models\Loja;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Cashier\Cashier;

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
        Cashier::useCustomerModel(Loja::class);

        DatePicker::configureUsing(function (DatePicker $datePicker): void {
            $datePicker->displayFormat('d/m/Y');
            $datePicker->native(false);
            $datePicker->firstDayOfWeek(7);
        });

        Page::$reportValidationErrorUsing = function (ValidationException $exception) {
            Notification::make()
                ->title('Erro de validação')
                ->body($exception->getMessage())
                ->danger()
                ->color("danger")
                ->send();
        };
    }
}
