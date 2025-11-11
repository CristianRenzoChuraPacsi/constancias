<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Vehiculo extends Model
{
    protected $connection = 'mysql'; // Base de datos principal
    protected $table = 'vehiculos';
    
    protected $fillable = [
        'placa',
        'modelo',
        'capacidad',
        'tenant_id',
    ];

    protected $primaryKey = 'id';
    protected $guarded = 'id';
    public $timestamps = true;

    protected static function booted()
    {
        static::addGlobalScope('tenant', function ($builder) {
            $user = Auth::user();
            if ($user && !$user->hasRole('super_admin')) {
                $builder->where('tenant_id', $user->tenant_id);
            }
        });

        static::creating(function ($model) {
            $user = Auth::user();
            if ($user && empty($model->tenant_id) && !$user->hasRole('super_admin')) {
                $model->tenant_id = $user->tenant_id;
            }
        });
    }
}
