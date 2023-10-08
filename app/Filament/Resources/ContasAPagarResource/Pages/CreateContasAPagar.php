<?php

namespace App\Filament\Resources\ContasAPagarResource\Pages;

use App\Filament\Resources\ContasAPagarResource;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateContasAPagar extends CreateRecord
{
    protected static string $resource = ContasAPagarResource::class;

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
            ->title('Conta a pagar criada')
            ->color("success")
            ->body('Conta a pagar foi criada com sucesso!')
            ->sendToDatabase($recipient);
    }
}
