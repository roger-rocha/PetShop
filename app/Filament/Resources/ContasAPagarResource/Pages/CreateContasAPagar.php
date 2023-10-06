<?php

namespace App\Filament\Resources\ContasAPagarResource\Pages;

use App\Filament\Resources\ContasAPagarResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreateContasAPagar extends CreateRecord
{
    protected static string $resource = ContasAPagarResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['loja_id'] = Filament::getTenant()->id;

        return $data;
    }

    public function contasAPagar(): HasMany {
        return $this->hasMany(contasAPagar::class);
    }
}
