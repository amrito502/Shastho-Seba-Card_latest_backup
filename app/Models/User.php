<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const ROLE_SUPERADMIN = 'SUPERADMIN';
    const ROLE_admin = 'admin';
    const ROLE_USER = 'USER';

    const ROLE_DEFAULT = self::ROLE_SUPERADMIN;

    const ROLES = [
        self::ROLE_SUPERADMIN => 'SuperAdmin',
        self::ROLE_admin => 'admin',
        self::ROLE_USER => 'User'
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }

    public function isSuperAdmin()
    {
        return $this->role === self::ROLE_SUPERADMIN;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_admin;
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'admin_id');
    }

    public function load_money()
    {
        return $this->hasMany(LoadMoney::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'balance'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
