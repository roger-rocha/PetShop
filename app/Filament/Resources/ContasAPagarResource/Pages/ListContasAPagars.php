<?php

namespace App\Filament\Resources\ContasAPagarResource\Pages;

use App\Filament\Resources\ContasAPagarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContasAPagars extends ListRecords
{
    protected static string $resource = ContasAPagarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label("Nova Conta"),
        ];
    }
}
