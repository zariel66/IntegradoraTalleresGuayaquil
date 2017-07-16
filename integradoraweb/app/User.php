<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    
    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $fillable = array('id', 'nombre', 'apellido', 'cedula', 'tipo', 'username', 'correo', 'password', 'remember_token','pass_token');
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function vehiculos()
    {
        return $this->hasMany('App\Vehiculo', 'idusuario', 'id');
    }

    public function talleres()
    {
        return $this->hasMany('App\Taller', 'idusuario', 'id');
    }

    public function calificaciones()
    {
        return $this->hasMany('App\Calificacion', 'idusuario', 'id');
    }
}
