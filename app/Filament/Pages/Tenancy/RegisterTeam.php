<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Loja;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Criar uma loja';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->name('Nome da loja')
                    ->required(),
                TextInput::make('phone')
                    ->name('telefone')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('endereco')
                    ->required(),
                TextInput::make('cep')
                    ->required(),
                TextInput::make('cidade')
                    ->required(),
                TextInput::make('estado')
                    ->required(),
                TextInput::make('bairro')
                    ->required(),
            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        $team = Loja::create($data);

        $team->users()->attach(auth()->user());

        return $team;
    }
}
