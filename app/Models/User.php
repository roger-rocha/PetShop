<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\PasswordReset;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasTenants
{
    // ...
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    // ...

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->status == 'Ativo';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
        'telefone',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(string $permission): bool
    {
        $permissonArray = [];

        foreach ($this->roles as $role) {
            foreach ($role->permissions as $singlePermission) {
                $permissonArray[] = $singlePermission->title;
            }
        }

        return collect($permissonArray)->unique()->contains($permission);
    }

    public function hasRole(string $role): bool
    {
        return $this->roles->contains('title', $role);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->lojas;
    }

    public function lojas(): BelongsToMany
    {
        return $this->belongsToMany(Loja::class);
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->lojas->contains($tenant);
    }

    public function ActivityLog()
    {
        return $this->hasMany(ActivityLog::class, 'causer_id');
    }
}
