<?php

namespace App\Filament\Super\Resources\ActivityLogResource\Pages;

use App\Filament\Super\Resources\ActivityLogResource;
use App\Models\User;
use Filament\Resources\Pages\EditRecord;

class EditActivityLog extends EditRecord
{
    protected static string $resource = ActivityLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['user'] = User::where('id', $data['causer_id'])->value('name');
        $data['properties'] = json_decode($data['properties']);

        return $data;
    }


    protected function getFormActions(): array
    {
        return [
            // ...parent::getFormActions(),
            // Action::make('close')->action('saveAndClose'),
        ];
    }
}
