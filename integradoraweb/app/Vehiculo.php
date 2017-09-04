<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
	protected $table = 'vehiculo';
    protected $primaryKey = 'id';
    protected $fillable = ['idmarca','modelo'];
    public $timestamps = false;
    public function marca()
    {
    	 return $this->belongsTo('App\Marca', 'idmarca');
    }
}
