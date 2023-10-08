<?php

namespace App\Filament\Super\Resources\ReleasesResource\Pages;

use App\Filament\Super\Resources\ReleasesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageReleases extends ManageRecords
{
    protected static string $resource = ReleasesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('F2 - Adicionar')
                ->keyBindings('f2'),
        ];
    }


}
