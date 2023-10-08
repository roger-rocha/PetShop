<?php

namespace App\Filament\Resources\ContaAReceberResource\Pages;

use App\Filament\Resources\ContaAReceberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContaARecebers extends ListRecords
{
    protected static string $resource = ContaAReceberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
