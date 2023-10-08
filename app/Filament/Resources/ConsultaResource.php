<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultaResource\Pages;
use App\Filament\Resources\ConsultaResource\RelationManagers;
use App\Models\Consulta;
use App\Models\Paciente;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConsultaResource extends Resource
{
    protected static ?string $model = Consulta::class;

    protected static ?string $navigationGroup = 'Pets';
    protected static ?string $navigationLabel = 'Consultas';

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Dados Cadastrais")
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('nome')
                                    ->label("Nome")
                                    ->required(),
                                Select::make('paciente_id')
                                    ->label("Pet")
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->options(Paciente::query()->where('loja_id', Filament::getTenant()->id)->pluck('nome', 'id'))
                                    ->required(),
                                DateTimePicker::make('data')
                                    ->native(false)
                                    ->displayFormat("d/m/Y H:i")
                                    ->label("Data")
                                    ->seconds(false)
                                    ->required(),
                            ]),
                        RichEditor::make('descricao')
                            ->label("Descrição")
                    ])
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
                Tables\Columns\TextColumn::make('paciente.nome')
                    ->label("Pet")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data')
                    ->dateTime("d/m/Y H:i")
                    ->label("Data")
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->emptyStateDescription("Não há nenhuma consulta cadastrada")
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label("Nova Consulta")
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
            'index' => Pages\ListConsultas::route('/'),
            'create' => Pages\CreateConsulta::route('/create'),
            'edit' => Pages\EditConsulta::route('/{record}/edit'),
        ];
    }
}
