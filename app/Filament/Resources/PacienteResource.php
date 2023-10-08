<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PacienteResource\Pages;
use App\Filament\Resources\PacienteResource\RelationManagers;
use App\Models\Paciente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PacienteResource extends Resource
{
    protected static ?string $model = Paciente::class;
    protected static ?string $navigationLabel = 'Pets';

    protected static ?string $label = 'Pets';
    protected static ?string $pluralLabel = 'Pets';

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Pets';

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
                                Forms\Components\DatePicker::make("data_nascimento")
                                    ->label("Data de Nascimento")
                                    ->displayFormat("d/m/Y")
                                    ->native(false)
                                    ->required(),
                                Forms\Components\Select::make("tipo")
                                    ->native(false)
                                    ->preload()
                                    ->options([
                                        "cachorro" => "Cachorro",
                                        "gato" => "Gato",
                                        "passaro" => "Pássaro"
                                    ])
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("nome")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("data_nascimento")
                    ->dateTime("d/m/Y")
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'cachorro' => 'success',
                        'gato' => 'warning',
                        'passaro' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'cachorro' => 'Cachorro',
                        'gato' => 'Gato',
                        'passaro' => 'Pássaro',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->emptyStateDescription("Não há nenhum pet cadastrado")
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label("Novo Pet")
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
            'index' => Pages\ListPacientes::route('/'),
            'create' => Pages\CreatePaciente::route('/create'),
            'edit' => Pages\EditPaciente::route('/{record}/edit'),
        ];
    }
}
