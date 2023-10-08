<?php

namespace App\Filament\Super\Pages\Auth;

use App\Filament\Suporte\Pages\Auth\view;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as AuthLogin;
use Filament\Pages\Concerns\InteractsWithFormActions;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;

class Login extends AuthLogin
{
    use InteractsWithFormActions;
    use WithRateLimiting;

    /**
     * @var view-string
     */
    protected static string $view = 'filament-panels::pages.auth.login';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function getPassword($value): void
    {
        if (!is_null($value)) {
            $this->data['password'] = $value;
        }
    }

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    /**
     * @throws GuzzleException
     * @throws ValidationException
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        // Tentativa de autenticação normal no banco de dados principal
        if (Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            // Autenticação bem-sucedida no banco de dados principal
            // Faça o que for necessário, como definir sessões ou redirecionar

            // Iniciar a sessão para o usuário autenticado
            Auth::login(Filament::auth()->user());

        } else {
            // Ambas as tentativas de autenticação falharam
            Notification::make()
                ->title('Erro de autenticação')
                ->icon('heroicon-o-x-circle')
                ->danger()
                ->color('danger')
                ->body('Verifique suas credenciais.')
                ->send();
            throw ValidationException::withMessages([
                'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),

            ])
            ->statePath('data');
    }

    public function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Email')
            ->required()
            ->exists()
            ->autocomplete()
            ->autofocus()
            ->placeholder('exemplo@email.com');
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/login.form.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()"> {{ __(\'filament-panels::pages/auth/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->password()
            ->live()
            ->type('password')
            ->autocomplete('current-password')
            ->required();
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label('Permanecer conectado');
    }

    public function registerAction(): Action
    {
        return Action::make('register')
            ->link()
            ->label(__('filament-panels::pages/auth/login.actions.register.label'))
            ->url(filament()->getRegistrationUrl());
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament-panels::pages/auth/login.title');
    }

    public function getHeading(): string|Htmlable
    {
        return 'Login';
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
        ];
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label('Entrar')
            ->icon('heroicon-o-lock-closed')
            ->submit('authenticate');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'telefone';
        if (strpos($data['login'], '@') === false) {
            $data['login'] = preg_replace('/[^0-9]/', '', $data['login']);
            $user = User::where('telefone', $data['login'])->where('status', 'Ativo')->first();
            if (!$user) {
                return [
                    $login_type => 'erro',
                    'password' => $data['password'],
                ]; // Usuário não encontrado ou não está ativo
            }
        } else {
            $user = User::where('email', $data['login'])->where('status', 'Ativo')->first();
            if (!$user) {
                return [
                    $login_type => 'erro',
                    'password' => $data['password'],
                ]; // Usuário não encontrado ou não está ativo
            }
        }

        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'telefone';

        return [
            $login_type => $data['login'],
            'password' => $data['password'],
        ];
    }

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->danger()
            ->send();
    }
}
