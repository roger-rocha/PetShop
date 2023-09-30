<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReleasesResource\Pages;
use App\Models\Releases;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReleasesResource extends Resource
{
    protected static ?string $model = Releases::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationGroup = 'W2O';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('titulo')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('data_release')
                    ->required(),
                Section::make('Descrição')->schema([
                    RichEditor::make('descricao')
                        ->label('')
                        ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Digite a descrição do chamado')->hidden(! Auth()->user()->hasRole('Super')),
                    RichEditor::make('descricao')
                        ->label('')
                        ->hintIcon('heroicon-m-exclamation-circle', tooltip: 'Você não tem permissão para escrever nesse campo')->disabled()->hidden(Auth()->user()->hasRole('Super')),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_release')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->color('primary'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReleases::route('/'),
        ];
    }
}
