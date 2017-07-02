<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
	protected $table = 'calificacion';
    protected $primaryKey = 'id';


	public function user()
	{
	    return $this->belongsTo('App\User', 'idusuario',"id");
	}
}
