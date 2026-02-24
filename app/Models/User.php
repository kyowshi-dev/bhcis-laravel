<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    private ?string $cachedRoleName = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roleName(): ?string
    {
        if ($this->cachedRoleName !== null) {
            return $this->cachedRoleName;
        }

        if ($this->role_id === null) {
            return null;
        }

        $this->cachedRoleName = DB::table('user_roles')
            ->where('id', $this->role_id)
            ->value('role_name');

        return $this->cachedRoleName;
    }

    public function hasRole(string ...$roles): bool
    {
        $roleName = $this->roleName();

        if ($roleName === null) {
            return false;
        }

        return in_array($roleName, $roles, true);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function isNurse(): bool
    {
        return $this->hasRole('Nurse');
    }

    public function isBhw(): bool
    {
        return $this->hasRole('BHW');
    }
}
