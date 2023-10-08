<?php

namespace App\Filament\Resources\ContaAReceberResource\Pages;

use App\Filament\Resources\ContaAReceberResource;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateContaAReceber extends CreateRecord
{
    protected static string $resource = ContaAReceberResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['loja_id'] = Filament::getTenant()->id;

        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color("success")
            ->title('Entrada criada')
            ->body('Entrada foi criada com sucesso!')
            ->sendToDatabase(auth()->user());
    }
}
