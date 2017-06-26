<?php

namespace App\Http\Controllers;
use DB;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Controllers\Controller;
use App\Marca;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;


class ClienteController extends Controller
{
	public function __construct()
    {
        $this->middleware('myauth');
    }
    
	public function busquedaTaller()
	{
		//$marcas = DB::table('marca')->orderBy("nombre","ASC")->get();
		return view("client.busquedataller");
	}

	public function busquedaTaller2()
	{
		$servicio = Input::get('servicio');
		$vehiculo =  Input::get('vehiculo');
		$latitude = Input::get('latitude');
		$longitude =  Input::get('longitude');
		error_log("servicio " . $servicio);
		error_log("lat: " . $latitude);
		error_log("lNG: " . $longitude);
		//error_log("lNG: " . $longitude);
		$workshops = DB::select("select distinct t.*,6371*2*   asin( sqrt( power(sin(((". $latitude ." - t.latitud)*pi()/180) / 2),2)  + cos(". $latitude ." * pi()/180) * cos( t.latitud  *  pi()/180) * power( sin( (". $longitude ." - t.longitud) * pi()/180),2 )) )
			 as distance
			 from taller as t INNER JOIN servicio_taller as st ON t.id = st.idtaller INNER JOIN marca_taller as mt ON mt.idtaller=t.id INNER JOIN marca as m on mt.idmarca = m.id where st.categoria = '". $servicio ."' and mt.idmarca = ". $vehiculo ." 
			 having distance< 2
			 ORDER BY distance limit 10");
		$html = view('client.snippet.searchresultlist')->with(array('results' => $workshops ))->render();
		return response()->json(array('workshops' => $workshops, "html" => $html));
	}
	
}
