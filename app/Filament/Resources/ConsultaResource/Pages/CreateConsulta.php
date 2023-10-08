<?php

namespace App\Filament\Resources\ConsultaResource\Pages;

use App\Filament\Resources\ConsultaResource;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateConsulta extends CreateRecord
{
    protected static string $resource = ConsultaResource::class;

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
        $recipient = auth()->user();

        return Notification::make()
            ->success()
            ->title('Consulta criada')
            ->color("success")
            ->body('Consulta foi criada com sucesso!')
            ->sendToDatabase($recipient);
    }
}
