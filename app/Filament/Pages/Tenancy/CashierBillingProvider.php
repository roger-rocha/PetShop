<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Billing\Providers\Contracts\Provider;
use Illuminate\Http\RedirectResponse;

class CashierBillingProvider implements Provider
{
    public function getRouteAction(): string
    {
        return function (): RedirectResponse {
            return redirect('https://billing.example.com');
        };
    }

    public function getSubscribedMiddleware(): string
    {
        return RedirectIfUserNotSubscribed::class;
    }
}
