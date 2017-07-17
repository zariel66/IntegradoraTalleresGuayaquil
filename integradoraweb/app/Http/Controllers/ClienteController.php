<?php

namespace App\Http\Controllers;
use DB;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Controllers\Controller;
use App\Marca;
use App\Taller;
use App\Calificacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
	public function __construct()
    {
        $this->middleware('myauth');
        //$this->middleware('sslp');
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
		$distancia =  Input::get('distancia');
		// error_log("servicio " . $servicio);
		// error_log("lat: " . $latitude);
		// error_log("lNG: " . $longitude);
		error_log("distancia: " . $distancia);
		$workshops = DB::select("select distinct t.*,6371*2*   asin( sqrt( power(sin(((". $latitude ." - t.latitud)*pi()/180) / 2),2)  + cos(". $latitude ." * pi()/180) * cos( t.latitud  *  pi()/180) * power( sin( (". $longitude ." - t.longitud) * pi()/180),2 )) )
			 as distance
			 from taller as t INNER JOIN servicio_taller as st ON t.id = st.idtaller INNER JOIN marca_taller as mt ON mt.idtaller=t.id INNER JOIN marca as m on mt.idmarca = m.id where st.categoria = '". $servicio ."' and mt.idmarca = ". $vehiculo ." 
			 having distance< ". $distancia ."
			 ORDER BY distance limit 10");
		$html = view('client.snippet.searchresultlist')->with(array('results' => $workshops ))->render();
		return response()->json(array('workshops' => $workshops, "html" => $html));
	}
	
	public function perfilTaller($id)
	{
		
		
		$iduser = Auth::user()->id;
		$taller =  Taller::find($id);
		$comentarios = $taller->calificaciones()->where('estado', 1)->orderBy('fecha_hora', 'desc')->paginate(10);
		return view("client.perfiltaller",array("taller" => $taller,"idusuario" => $iduser,"comentarios" => $comentarios));
	}

	public function nuevaEvaluacion()
	{
		$desc_code = str_random(8);
		try {
			
			$id = DB::table('calificacion')->insertGetId(
		    ['idusuario' => Auth::user()->id,
		     'idtaller' => Input::get('idtaller'),
		     'estado' => 0,
		     'desc_code' => $desc_code,
		     'fecha_hora' => \Carbon\Carbon::now()
		    ]
			);
			
			return array("desc_code" => $desc_code, "success" =>1);
		} catch (\Exception $e) {
			return array("desc_code" => $desc_code, "success" =>0);
		}
		
	}

	public function evaluacionesRecomendaciones()
	{
		
		$reviews = Auth::user()->calificaciones()->where('estado', 2)->paginate(1);
		return view("client.encuesta", array('reviews' => $reviews ));
	}

	public function calificacionNuevaEvaluacion()
	{
		try {
			$honestidad = Input::get('honestidad');
			$precio = Input::get('precio');	
			$eficiencia = Input::get('eficiencia');
			$idcalificacion = Input::get('idcalificacion');	
			$comentario = Input::get('comentario');
			$calificacion = Calificacion::find($idcalificacion);
			$taller = $calificacion->taller;

			$rules = array(
			'comentario' => 'required|min:10',
			
			); 


			$custom = array(
				"comentario.required" => "El :attribute es requerido",
				
				"comentario.min" => "El :attribute debe tener mínimo :min caracteres",
				


				);

			$validation = Validator::make(Input::all(),$rules,$custom);

			if ($validation->fails())
			{
				error_log("entro controller validacion");
				return Redirect::back()->withErrors($validation)->withInput(Input::all());
			}

			DB::beginTransaction();
			$calificacion->update(
			[
				"honestidad"=> $honestidad,
				"eficiencia"=> $eficiencia,
				"precio"=> $precio,
				"comentario"=> $comentario,
				"estado" => 1,
				'fecha_hora' => \Carbon\Carbon::now()
			]);
			$calificaciones = $taller->calificaciones->where("estado",1);
			$honestidad_prom = 0;
			$eficiencia_prom = 0;
			$precio_prom = 0;
			foreach ($calificaciones as $c ) {
				$honestidad_prom = $honestidad_prom + $c->honestidad;
				$eficiencia_prom = $eficiencia_prom + $c->eficiencia;
				$precio_prom = $precio_prom + $c->precio;
			}
			$tam = count($calificaciones);
			$honestidad_prom = $honestidad_prom /$tam;
			$eficiencia_prom = $eficiencia_prom /$tam;
			$precio_prom = $precio_prom /$tam;
			$taller->update(
			[
				"honestidad"=> $honestidad_prom,
				"eficiencia"=> $eficiencia_prom,
				"precio"=> $precio_prom,
				
			]);
			
			session(['pendingreview' => session()->get('pendingreview') - 1]);

		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
			return redirect("evaluacionservicio");	
		}
		DB::commit();
		if(session()->get('pendingreview') >0)
		{
			return redirect("evaluacionservicio");
		}
		else
		{
			return redirect("perfiltaller/" . $taller->id);
		}
	}
}
