<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditTeamProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Perfil da loja';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Dados Cadastrais")
                    ->schema([
                        TextInput::make('name')
                            ->label("Nome")
                            ->required(),
                        Fieldset::make("Endereço")
                            ->schema([
                                TextInput::make("cep")
                                    ->numeric()
                                    ->mask("99999-99")
                                    ->placeholder("99999-99")
                                    ->label("CEP"),
                                TextInput::make("endereco")
                                    ->label("Endereço"),
                                Grid::make(3)->schema([
                                    TextInput::make("estado")
                                        ->label("Estado"),
                                    TextInput::make("cidade")
                                        ->label("Cidade"),
                                    TextInput::make("bairro")
                                        ->label("Bairro"),
                                ])
                            ])
                    ])
            ]);
    }
}
