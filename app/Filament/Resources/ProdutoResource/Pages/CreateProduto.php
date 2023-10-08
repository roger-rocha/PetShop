<?php

namespace App\Filament\Resources\ProdutoResource\Pages;

use App\Filament\Resources\ProdutoResource;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateProduto extends CreateRecord
{
    protected static string $resource = ProdutoResource::class;

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
            ->title('Produto criado')
            ->body('Produto foi criado com sucesso!')
            ->sendToDatabase(auth()->user());
    }
}
