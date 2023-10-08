<?php

namespace App\Filament\Super\Resources\UserResource\Pages;

use App\Filament\Super\Resources\UserResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['telefone'] = preg_replace('/[^0-9]/', '', $data['telefone']);
        if ($this->validadeUserPermission($data)) {
            if (isset($data['foto'])) {
                $data['user_id'] = auth()->id();
                $telefone = $data['telefone']; // Certifique-se de ajustar o nome do campo para corresponder à sua requisição

                // Remover caracteres não numéricos do telefone
                $numeroTelefone = preg_replace('/[^0-9]/', '', $telefone);

                // Recuperar o nome original da imagem da requisição
                $nomeImagemOriginal = $data['foto'];

                // Obter a extensão da imagem
                $extensaoImagem = pathinfo($nomeImagemOriginal, PATHINFO_EXTENSION);

                // Gerar o novo nome da imagem usando o número de telefone
                $nomeFile = 'public/fotos-perfil/' . $numeroTelefone . '.' . $extensaoImagem;

                // Renomear e mover a imagem para o novo local

                Storage::copy($data['foto'], $nomeFile);

                Storage::move($data['foto'], $nomeFile);
                $data['foto'] = $nomeFile;
            } else {
                $data['foto'] = 'public/fotos-perfil/user.png';
            }

            return $data;
        } else {
            return [];
        }
    }

    public function validadeUserPermission($data)
    {
        $user = Auth()->user();
        if (!$user->hasRole('Super')) {
            $modifyUser = User::where('id', $data['id'])->get();

            if (!$modifyUser->hasRole('Super')) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color("success")
            ->title('Usuário criado')
            ->body('Usuário foi criado com sucesso!')
            ->sendToDatabase(auth()->user());
    }
}
