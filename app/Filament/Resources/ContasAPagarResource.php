<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContasAPagarResource\Pages;
use App\Filament\Resources\ContasAPagarResource\RelationManagers;
use App\Models\ContasAPagar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Money;

class ContasAPagarResource extends Resource
{
    protected static ?string $model = ContasAPagar::class;

    protected static ?string $label = 'Saída';
    protected static ?string $modelLabel = 'Saídas';
    protected static ?string $modelLabelPlural = 'Saídas';
    protected static ?string $pluralLabel = 'Saídas';
    protected static ?string $navigationLabel = 'Saídas';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-down';

    protected static ?string $navigationGroup = 'Financeiro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make("Dados Cadastrais")
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make("nome")
                                    ->label("Nome")
                                    ->required(),
                                Money::make("preco")
                                    ->label("Preço")
                                    ->required(),
                                Money::make("valor_pago")
                                    ->label("Valor Pago")
                                    ->required(),
                                Forms\Components\Select::make('tipo')
                                    ->searchable()
                                    ->preload()
                                    ->options([
                                        'Fornecedor' => 'Fornecedor',
                                        'Despesa Fixa' => 'Despesa Fixa',
                                        'Funcionarios' => 'Funcionários',
                                        'Outros' => 'Outros',
                                    ])
                                    ->required(),
                                Forms\Components\DatePicker::make("data_vencimento")
                                    ->label("Data de Vencimento")
                                    ->displayFormat("d/m/Y")
                                    ->native(false)
                                    ->required(),
                                Forms\Components\DatePicker::make("data_pagamento")
                                    ->label("Data de Pagamento")
                                    ->displayFormat("d/m/Y")
                                    ->native(false)
                                    ->required(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("nome")
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("preco")
                    ->label('Preço')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("valor_pago")
                    ->label('Valor Pago')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("tipo")
                    ->label('Tipo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("data_vencimento")
                    ->label('Data de vencimento')
                    ->dateTime("d/m/Y")
                    ->sortable(),
                Tables\Columns\TextColumn::make("data_pagamento")
                    ->label('Data de pagamento')
                    ->dateTime("d/m/Y")
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->emptyStateDescription("Não há nenhuma saída cadastrada")
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label("Nova Saída")
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContasAPagars::route('/'),
            'create' => Pages\CreateContasAPagar::route('/create'),
            'edit' => Pages\EditContasAPagar::route('/{record}/edit'),
        ];
    }
}
