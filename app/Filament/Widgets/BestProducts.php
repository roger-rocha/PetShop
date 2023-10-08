<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProdutoResource;
use App\Models\Produto;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class BestProducts extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Produtos mais vendidos';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(ProdutoResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make("nome")
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("descricao")
                    ->label('Descrição')
                    ->html()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("preco")
                    ->label('Preço')
                    ->formatStateUsing(fn(string $state): string => 'R$ ' . number_format($state, 2, ',', '.'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("quantidade")
                    ->label('Quantidade')
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->url(fn(Produto $record): string => ProdutoResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
