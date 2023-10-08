<?php

namespace App\Filament\Resources\ContaAReceberResource\Pages;

use App\Filament\Resources\ContaAReceberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContaAReceber extends EditRecord
{
    protected static string $resource = ContaAReceberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
