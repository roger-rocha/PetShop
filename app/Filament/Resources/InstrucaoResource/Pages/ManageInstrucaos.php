<?php

namespace App\Filament\Resources\instrucaoResource\Pages;

use App\Filament\Resources\instrucaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\View\View;

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
