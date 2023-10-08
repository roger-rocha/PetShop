<?php

namespace App\Filament\Super\Resources\InstrucaoResource\Pages;

use App\Filament\Super\Resources\instrucaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class Manageinstrucaos extends ManageRecords
{
    protected static string $resource = InstrucaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('F2 - Adicionar')
                ->keyBindings('f2'),
        ];
    }


}
