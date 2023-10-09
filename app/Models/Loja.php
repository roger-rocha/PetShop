<?php

namespace App\Models;

use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Cashier\Billable;

class Loja extends Model implements HasCurrentTenantLabel

{
    use HasFactory, Billable;

    protected $table = "loja";

    protected $fillable = [
        "name",
        "phone",
        "email",
        "endereco",
        "cep",
        "cidade",
        "estado",
        "bairro"
    ];

    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(User::class, 'loja_user', 'loja_id', 'user_id');
    }

    public function pacientes(): HasMany
    {
        return $this->hasMany(Paciente::class);
    }

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class);
    }

    public function contasAPagars(): HasMany
    {
        return $this->hasMany(ContasAPagar::class);
    }

    public function contasARecebers(): HasMany
    {
        return $this->hasMany(ContasAReceber::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function getCurrentTenantLabel(): string
    {
        return 'Selecionar loja';
    }

}
