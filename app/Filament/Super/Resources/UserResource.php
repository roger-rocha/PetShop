<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\UserResource\Pages;
use App\Filament\Super\Resources\UserResource\RelationManagers\LojasRelationManager;
use App\Models\User;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $modelLabel = 'Usuários';
    protected static ?string $navigationGroup = 'Usuários';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        function getAvatarInput(): component
        {
            return Section::make('Avatar')->description('Foto de perfil.')->schema([
                FileUpload::make('foto')
                    ->image()
                    ->imageEditor()->label('Foto')
                    ->disk('local')
                    ->directory('/public/fotos-perfil')
                    ->visibility('private')
                    ->imagePreviewHeight('250'),
            ]);
        }

        function getInformacaoPessoal(): component
        {
            return Group::make([
                Section::make('Informação pessoal')
                    ->schema([
                        Hidden::make('id'),
                        TextInput::make('name')->label('Nome completo')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')->label('Email')->unique(ignoreRecord: true)
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('telefone')
                            ->unique(ignoreRecord: true)
                            ->label('Telefone')
                            ->required()
                            ->mask("(99) 99999-9999")
                            ->placeholder("(99) 99999-9999")
                    ]),
            ]);
        }

        function getPasswordInput(): component
        {
            return Section::make('Dados de Acesso')
                ->columns([
                    'sm' => 2,
                    'xl' => 2,
                    '2xl' => 2,
                ])
                ->schema([
                    Toggle::make('passwordDisable')
                        ->label('Redefinir senha')
                        ->default(true)
                        ->dehydrated()
                        ->live()
                        ->hiddenOn('create'),
                    Section::make()->schema([
                        Group::make([
                            TextInput::make('password')
                                ->placeholder('*********')
                                ->label('Senha')
                                ->password()
                                ->nullable()
                                ->confirmed()
                                ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                                ->dehydrated(fn(?string $state): bool => filled($state))
                                ->required(fn(string $context): bool => $context === 'create')
                                ->rules([
                                    'min:8',
                                    'string',
                                    'confirmed', // Campo de confirmação da senha
                                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                                ])
                                ->autocomplete(false)->disabled(fn(Get $get): bool => !$get('passwordDisable'))->hintIcon(
                                    'heroicon-m-question-mark-circle',
                                    tooltip: function () {
                                        $result = DB::table('instrucao')
                                            ->where('alias', 'Senha')
                                            ->value('texto');

                                        return $result ? $result : 'Tooltip content not available.';
                                    }
                                ),
                        ]),
                        Group::make([
                            TextInput::make('password_confirmation')
                                ->placeholder('*********')
                                ->password()
                                ->label('Confirmar senha')
                                ->required(fn(string $context): bool => $context === 'create')
                                ->rules([
                                    'min:8',
                                ])
                                ->autocomplete(false)->disabled(fn(Get $get): bool => !$get('passwordDisable')),
                        ]),
                    ]),
                ]);
        }

        function getPermissaoInput(): component
        {
            return Section::make('Permissões menu')
                ->schema([
                    Select::make('Permissão')
                        ->native(false)
                        ->relationship(
                            name: 'roles',
                            titleAttribute: 'title',
                            modifyQueryUsing: fn(Builder $query) => Auth()->user()->hasRole('Super') ? null : $query->where('title', '!=', 'Inativo')->where('title', '!=', 'Super'),
                        ),
                    Select::make('status')
                        ->native(false)
                        ->options([
                            'Ativo' => 'Ativo',
                            'Inativo' => 'Inativo',
                        ]),
                ]);
        }

        return $form
            ->schema([
                getAvatarInput()->disabled(fn(Get $get) => $get('Permissão')[0] == '1' && !Auth()->user()->hasRole('Super'))->visibleOn('edit'),
                getAvatarInput()->visibleOn('create'),
                getInformacaoPessoal()->visibleOn('create'),
                getInformacaoPessoal()->disabled(fn(Get $get) => $get('Permissão')[0] == '1' && !Auth()->user()->hasRole('Super'))->visibleOn('edit'),
                Group::make([
                    getPasswordInput()->visibleOn('edit')->disabled(fn(Get $get) => $get('Permissão')[0] == '1' && !Auth()->user()->hasRole('Super')),
                    getPasswordInput()->visibleOn('create'),
                ]),
                getPermissaoInput()->disabled(fn(Get $get) => $get('Permissão')[0] == '1' && !Auth()->user()->hasRole('Super'))->visibleOn('edit'),
                getPermissaoInput()->visibleOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_url')
                    ->label('Foto')
                    ->disk('local')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('telefone')
                    ->label('Telefone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.title')
                    ->label('Função')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Ativo' => 'success',
                        'Inativo' => 'danger',
                    }),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
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
                ActionGroup::make([
                    Tables\Actions\EditAction::make()->color('primary'),
                    ActionsAction::make('Inativar')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (User $user) {
                            $user->status = 'Inativo';
                            $user->roles->title = 'User';
                            $user->save();
                        })->hidden(function (User $user) {
                            return $user->status == 'Inativo';
                        })->disabled(!Auth()->user()->hasPermission('user_status_edit')),

                    ActionsAction::make('Ativar')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (User $user) {
                            $user->status = 'Ativo';
                            $user->roles->title = 'User';
                            $user->save();
                        })->hidden(function (User $user) {
                            return $user->status != 'Inativo';
                        })->disabled(!Auth()->user()->hasPermission('user_status_edit')),

                    DeleteAction::make()->hidden(!Auth()->user()->hasRole('Super')),
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

    public static function getRelations(): array
    {
        return [
            LojasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
