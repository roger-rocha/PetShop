<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContaAReceberResource\Pages;
use App\Filament\Resources\ContaAReceberResource\RelationManagers;
use App\Models\ContaAReceber;
use App\Models\ContasAReceber;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Money;

class ContaAReceberResource extends Resource
{
    protected static ?string $model = ContasAReceber::class;

    protected static ?string $label = 'Entrada';
    protected static ?string $modelLabel = 'Entrada';
    protected static ?string $modelLabelPlural = 'Entradas';
    protected static ?string $pluralLabel = 'Entradas';

    protected static ?string $navigationGroup = 'Financeiro';
    protected static ?string $navigationLabel = 'Entradas';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Dados Cadatrais")
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make("nome")
                                    ->label("Nome")
                                    ->required(),
                                DatePicker::make("data_recebimento")
                                    ->label("Data de Recebimento")
                                    ->displayFormat("d/m/Y")
                                    ->native(false)
                                    ->required(),
                                Select::make("tipo")
                                    ->label("Tipo")
                                    ->required()
                                    ->native(false)
                                    ->options([
                                        'Cliente' => 'Cliente',
                                        'Compra' => 'Compra',
                                        'Consulta' => 'Consulta',
                                        'Outros' => 'Outros',
                                    ]),
                            ]),
                        Grid::make()
                            ->schema([
                                Money::make("preco")
                                    ->label("Preço")
                                    ->required(),
                                Money::make("valor_pago")
                                    ->label("Valor Pago")
                                    ->required(),
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label("Nome")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->label("Tipo")
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Cliente' => 'gray',
                        'Compra' => 'warning',
                        'Consulta' => 'success',
                        'Outros' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('preco')
                    ->label("Preço")
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => 'R$ ' . number_format($state, 2, ',', '.')),
                Tables\Columns\TextColumn::make('valor_pago')
                    ->label("Preço")
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => 'R$ ' . number_format($state, 2, ',', '.')),
                Tables\Columns\TextColumn::make('data_recebimento')
                    ->label("Data de Recebimento")
                    ->sortable()
                    ->date('d/m/Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->emptyStateDescription("Não há nenhuma entrada cadastrada")
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label("Nova Entrada")
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
            'index' => Pages\ListContaARecebers::route('/'),
            'create' => Pages\CreateContaAReceber::route('/create'),
            'edit' => Pages\EditContaAReceber::route('/{record}/edit'),
        ];
    }
}
