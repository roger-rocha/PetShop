<?php

namespace App\Filament\Resources\PacienteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ConsultaRelationManager extends RelationManager
{
    protected static string $relationship = 'consultas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('consulta')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('consulta')
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label("Nome")
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
