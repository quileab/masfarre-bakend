<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

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

    // Presupuestos creados por este usuario (si es admin)
    public function budgetsCreated()
    {
        return $this->hasMany(Budget::class, 'admin_id');
    }

    // Presupuestos asignados como cliente
    public function budgetsReceived()
    {
        return $this->hasMany(Budget::class, 'client_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Presupuestos creados por este usuario (si es admin)
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public static function getSessionUser()
    {
        return session()->get('user');
    }
}
