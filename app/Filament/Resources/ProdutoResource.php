<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdutoResource\Pages;
use App\Models\Produto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Money;


class ProdutoResource extends Resource
{
    protected static ?string $model = Produto::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Produtos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make("Dados Cadastrais")
                    ->schema([
                        Forms\Components\TextInput::make("nome")
                            ->label("Nome")
                            ->required(),
                        Forms\Components\RichEditor::make("descricao")
                            ->label("Descrição")
                            ->required(),
                        Forms\Components\Grid::make()->schema([
                            Money::make("preco")
                                ->label("Preço")
                                ->required(),
                            Forms\Components\TextInput::make("quantidade")
                                ->label("Quantidade")
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
                Tables\Columns\TextColumn::make("descricao")
                    ->label('Descrição')
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->emptyStateDescription("Não há nenhum produto cadastrado")
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label("Novo Produto")
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
            'index' => Pages\ListProdutos::route('/'),
            'create' => Pages\CreateProduto::route('/create'),
            'edit' => Pages\EditProduto::route('/{record}/edit'),
        ];
    }
}
