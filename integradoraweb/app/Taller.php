<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
	protected $table = 'taller';
    protected $primaryKey = 'id';
    protected $fillable = ['honestidad','precio','eficiencia'];
    public $timestamps = false;
    public function marcas()
    {
    	return $this->belongsToMany('App\Marca', 'marca_taller', 'idtaller', 'idmarca');
	}

	public function servicios()
	{
		return $this->hasMany('App\Servicio_Taller', 'idtaller', 'id');
	}

	public function calificaciones()
	{
		return $this->hasMany('App\Calificacion', 'idtaller', 'id');
	}
}
