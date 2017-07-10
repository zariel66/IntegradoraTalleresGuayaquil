<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
	protected $table = 'calificacion';
    protected $primaryKey = 'id';
    protected $fillable = ['honestidad', 'comentario', 'estado','precio','eficiencia','fecha_hora','precio_original','descuento','total'];
    public $timestamps = false;

	public function user()
	{
	    return $this->belongsTo('App\User', 'idusuario',"id");
	}

	public function taller()
	{
	    return $this->belongsTo('App\Taller', 'idtaller',"id");
	}
}
