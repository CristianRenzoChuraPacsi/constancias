<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'estado', // Añadido por consistencia con activar/desactivar
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Multi-tenant automático
    protected static function booted()
    {
        // Filtro global por tenant
        static::addGlobalScope('tenant', function ($builder) {
            $user = Auth::user();
            if ($user && !$user->hasRole('super_admin')) {
                $builder->where('tenant_id', $user->tenant_id);
            }
        });

        // Asignar tenant_id al crear
        static::creating(function ($model) {
            $user = Auth::user();
            if ($user && empty($model->tenant_id) && !$user->hasRole('super_admin')) {
                $model->tenant_id = $user->tenant_id;
            }
        });
    }
}
