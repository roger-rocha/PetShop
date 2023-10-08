<?php

namespace App\Filament\Resources\ContasAPagarResource\Pages;

use App\Filament\Resources\ContasAPagarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContasAPagar extends EditRecord
{
    protected static string $resource = ContasAPagarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
