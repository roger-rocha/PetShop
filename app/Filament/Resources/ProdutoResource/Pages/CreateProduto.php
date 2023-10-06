<?php

namespace App\Filament\Resources\ProdutoResource\Pages;

use App\Filament\Resources\ProdutoResource;
use App\Models\Produto;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreateProduto extends CreateRecord
{
    protected static string $resource = ProdutoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['loja_id'] = Filament::getTenant()->id;

        return $data;
    }

    public function produto(): HasMany {
        return $this->hasMany(Produto::class);
    }
}
