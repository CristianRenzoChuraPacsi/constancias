<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $connection = 'mysql'; // Base de datos principal
    protected $table = 'tenants';
    
    protected $fillable = [
        'siglas',
        'nombre',
        'razon_social',
        'ruc',
        'direccion',
        'telefono'
    ];

    protected $primaryKey = 'id';
    protected $guarded = 'id';
    public $timestamps = true;

    public function users()
    { 
        return $this->hasMany(User::class); 
    }
}
