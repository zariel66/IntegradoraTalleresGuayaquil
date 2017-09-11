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
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
class WorkshopController extends Controller
{
	public function __construct()
	{
		
	}
	public function userTickets()
	{
		
		$result = DB::table('calificacion')
		->join('taller', 'calificacion.idtaller', '=', 'taller.id')
		->join('usuario', 'calificacion.idusuario', '=', 'usuario.id')
		->where("calificacion.estado",0)
		->where("taller.idusuario",Auth::user()->id)
		->orderBy('usuario.nombre')
		->distinct()
		->select('calificacion.id','usuario.nombre', 'usuario.apellido','calificacion.desc_code','taller.nombre_taller')->get();
		
		return view("workshop.tickets",array('rows' => $result ));
	}

	public function busquedaTickets($opt)
	{
		$result = array();
		try {
			$termino = Input::get('term');
			
			
			if($opt == 1)
			{
				$talleres = User::find(Auth::user()->id)->talleres;
				$resultset = array();
				foreach ($talleres as $taller){
					foreach ($taller->calificaciones->where("estado",0) as $calificacion){    
						 $usuario = $calificacion->user;
						
						 if(stripos($usuario->nombre, $termino)!== false or stripos($usuario->apellido, $termino)!== false)
						 {
							array_push( $resultset, $usuario );
						 }
					}
				}
			   
				foreach($resultset as $r){
					$output = array( "label" => $r->nombre ." " . $r->apellido , "value" => $r->id);
					array_push( $result, $output );
				}
			}
			else if($opt == 2)
			{
				$resultset = DB::table('calificacion')
				->join('taller', 'calificacion.idtaller', '=', 'taller.id')
				->join('usuario', 'calificacion.idusuario', '=', 'usuario.id')
				->where('calificacion.desc_code', 'like',  $termino . '%')
				->where('calificacion.estado', 0)
				->where("taller.idusuario",Auth::user()->id)
				->distinct()
				->select('usuario.id','usuario.nombre', 'usuario.apellido')->get();
				foreach($resultset as $r){
					$output = array( "label" => $r->nombre ." " . $r->apellido , "value" => $r->id);
					array_push( $result, $output );
				}

			}
			
		} catch (\Exception $e) {
			throw $e;
			
			//return response()->json(array("success"=> 0));
		}
		error_log("llega al final");
		return response()->json($result);
	}

	public function cerrarTicket()
	{
		$id = Input::get('id');
		$precio = Input::get('precio');
		$descuento = Input::get('descuento');
		$total = Input::get('total');
		try {
			$rules = array(
			
			'precio' => 'required|numeric|min:0',
			'descuento' => 'required|numeric|min:1|max:100',
			'total' => 'required|numeric|min:0',
			
			); 
			$validation = Validator::make(Input::all(),$rules,array());

			if ($validation->fails())
			{
				error_log("UNIT TEST MESSAGE: MESSAGE BAG->" . $validation->getMessageBag()->toJson());
				throw new \Exception("Error Processing Request", 1);
				
			}
			$calificacion = Calificacion::find($id);
			$calificacion->update(
			[
			    "precio_original"=> $precio,
			    "descuento"=> $descuento,
			    "total"=> $total,
			    "estado" => 2,
			    'fecha_hora' => \Carbon\Carbon::now(),
			    'fecha_visita' => \Carbon\Carbon::now(),
			]);
			$output = "<strong>El código de la transacción ha sido confirmado. El usuario evaluará la calidad del servicio en los próximos días</strong>";
			// Mail::send('emails.reminder', ['calificacion' => $calificacion], function ($m) use ($calificacion) {
	  //           $m->from(config("constants.emails.from"), config("constants.app_name"));

	  //           $m->to($calificacion->user->correo, $calificacion->user->nombre)->subject('Ayúdanos evaluando la calidad del servicio');
	  //       });
		} catch (\Exception $e) {
			//throw $e;
			
			$output = "<strong>Hubo un error al procesar los datos intente después</strong>";
			return response()->json(array('message' => $output , 'success'=> 0 ));
		}
		return response()->json(array('message' => $output , 'success'=> 1 ));
	}

	public function cargarTicket($id)
	{
		try {
		   $result = DB::table('calificacion')
			->join('taller', 'calificacion.idtaller', '=', 'taller.id')
			->join('usuario', 'calificacion.idusuario', '=', 'usuario.id')
			->where("calificacion.idusuario",$id)
			->where("taller.idusuario",Auth::user()->id)
			->distinct()
			->select('calificacion.id','usuario.nombre', 'usuario.apellido','calificacion.desc_code','taller.nombre_taller')->get();
			$html = view('workshop.snippet.ticketsrow')->with(array('rows' => $result ))->render();
			return response()->json(array("html"=>$html,"success"=>1));
		} catch (\Exception $e) {
			throw $e;
			
		}
		
	}

	public function perfilTaller()
	{
		try {
			$usuario = Auth::user();
			return view("workshop.miperfil",array("usuario" => $usuario));
		} catch (\Exception $e) {
			throw $e;
			
		}
	}

	public function mostrarTaller($id)
	{
		try {
			$taller =  Taller::find($id);
			if(is_null($taller))
			{
				abort(404);
			}
			$comentarios = $taller->calificaciones()->where('estado', 1)->orderBy('fecha_hora', 'desc')->paginate(5);
		return view("workshop.mostrartaller",array("taller" => $taller,"comentarios" => $comentarios));
		} catch (\Exception $e) {
			abort(500);
		}
	}

	public function editarTaller($id)
	{
		try {
			$taller =  Taller::find($id);
			if(is_null($taller))
			{
				abort(404);
			}
			$marcas= Marca::orderBy('nombre',"ASC")->get();
			return view("workshop.editartaller",array("taller"=> $taller,"marcas" => $marcas));
		} catch (\Exception $e) {
			abort(500);
		}
	}

	public function editarTallerSubmit($id)
	{
		$rules = array(
			
			'direccion' => 'required|min:10',
			'telefono' => 'required|regex:/^\(04\)[0-9]{7}$/',
			'nombre_empleado' => 'required|min:10',
			"marcas" => 'required|array|min:1',
			"servicios" => 'required|array|min:1',

			"nombre_taller" => "required|min:3"

			); 


		$custom = array(
			
			"telefono.required" => "El teléfono es requerido",
			"direccion.required" => "La dirección es requerida",
			"nombre_empleado.required" => "El nombre del empleado es requerido",
			"marcas.required" => "Debe seleccionar al menos una marca de vehículo con la que trabaja",
			"servicios.required" => "Debe seleccionar al menos un servicio que ofrece en su taller",
			"nombre_taller.required" => "El nombre del taller es requerido",

			"telefono.regex" => "El teléfono debe tener el formato de la ciudad de Guayaquil (04)XXXXXXX",
			"direccion.min" => "La dirección debe tener mínimo :min caracteres",
			"nombre_empleado.min" => "El nombre del empleado debe tener mínimo :min caracteres",
			"nombre_taller.min" => "El nombre del taller debe tener mínimo :min caracteres",


			);

		$validation = Validator::make(Input::all(),$rules,$custom);

		if ($validation->fails())
		{

			return Redirect::back()->withErrors($validation)->withInput(Input::all());
		}
		
		DB::beginTransaction();
		try {
			
			$taller =  Taller::find($id);
			if(is_null($taller))
			{
				abort(404);
			}
			$taller->update(
			[
			    "telefono"=> Input::get('telefono'),
			    "nombre_taller"=> Input::get('nombre_taller'),
			    "nombre_empleado"=> Input::get('nombre_empleado'),
			    "direccion"=> Input::get('direccion'),
			    "latitud"=> Input::get('lat'),
			    "longitud"=> Input::get('lon'),
			]);
			error_log(Input::get('nombre_empleado'));
			DB::table('marca_taller')->where('idtaller',$id)->delete();
			DB::table('servicio_taller')->where('idtaller',$id)->delete();
			foreach (Input::get('marcas') as $marca)
			{
				$id_marca_taller = DB::table('marca_taller')->insertGetId(
					array(
						"idmarca" => $marca,
						"idtaller" => $id,
						));
		
			}
			foreach (Input::get('servicios') as $servicio)
			{
				$id_servicio_taller = DB::table('servicio_taller')->insertGetId(
					array(
						"categoria" => $servicio,
						"idtaller" => $id,
						));
		
			}

		} catch (\Exception $e) {
			DB::rollback();
			error_log("ROLLBACK: ". $e->getMessage());
			abort(500);
		}
		DB::commit();
		return redirect("mostrartaller/". $id);
	}

	public function crearTaller()
	{
		$marcas= Marca::orderBy('nombre',"ASC")->get();
		return view("workshop.creartaller",array("marcas" => $marcas));
	}

	public function crearTallerSubmit()
	{
		$rules = array(
			
			'direccion' => 'required|min:10',
			'telefono' => 'required|regex:/^\(04\)[0-9]{7}$/',
			'nombre_empleado' => 'required|min:10',
			"marcas" => 'required|array|min:1',
			"servicios" => 'required|array|min:1',
			"nombre_taller" => "required|min:3"
			); 


		$custom = array(
			
			"telefono.required" => "El teléfono es requerido",
			"direccion.required" => "La dirección es requerida",
			"nombre_empleado.required" => "El nombre del empleado es requerido",
			"marcas.required" => "Debe seleccionar al menos una marca de vehículo con la que trabaja",
			"servicios.required" => "Debe seleccionar al menos un servicio que ofrece en su taller",
			"nombre_taller.required" => "El nombre del taller es requerido",

			"telefono.regex" => "El teléfono debe tener el formato de la ciudad de Guayaquil (04)XXXXXXX",
			"direccion.min" => "La dirección debe tener mínimo :min caracteres",
			"nombre_empleado.min" => "El nombre del empleado debe tener mínimo :min caracteres",
			"nombre_taller.min" => "El nombre del taller debe tener mínimo :min caracteres",


			);

		$validation = Validator::make(Input::all(),$rules,$custom);

		if ($validation->fails())
		{

			return Redirect::back()->withErrors($validation)->withInput(Input::all());
		}

		DB::beginTransaction();
		try {
			

			$idtaller = DB::table('taller')->insertGetId(
				array(

					'latitud' => Input::get('lat'),
					'longitud' => Input::get('lon'),
					'direccion' => Input::get('direccion'),
					'idusuario' => Auth::user()->id,
					'nombre_empleado' => Input::get('nombre_empleado'),
					'telefono' => Input::get('telefono'),
					"nombre_taller" => Input::get('nombre_taller'),
					"ciudad" => "Guayaquil"
					)
				);
			foreach (Input::get('marcas') as $marca)
			{
				$id_marca_taller = DB::table('marca_taller')->insertGetId(
					array(
						"idmarca" => $marca,
						"idtaller" => $idtaller
						));
		
			}
			foreach (Input::get('servicios') as $servicio)
			{
				$id_servicio_taller = DB::table('servicio_taller')->insertGetId(
					array(
						"categoria" => $servicio,
						"idtaller" => $idtaller
						));
		
			}

		} catch (\Exception $e) {
			DB::rollback();
			//throw $e;
			abort(500);
		}
		DB::commit();
		return redirect("mostrartaller/". $idtaller);
	}

	public function eliminarTaller($id)
	{
		try {
			DB::table('taller')->where('idusuario',Auth::user()->id)->where("id",$id)->delete();
		} catch (\Exception $e) {
			error_log("MENSAJE EXCEPCION: ". $e->getMessage());
			abort(500);
		}
		return redirect("perfiltallerowner");
	}

	public function historialTaller()
	{
		try {
			if(Request::ajax())
			{
				
				$result = DB::table('calificacion')
				->join('taller', 'calificacion.idtaller', '=', 'taller.id')
				->join('usuario', 'calificacion.idusuario', '=', 'usuario.id')
				->where(function ($query){
				    $query->where("calificacion.estado",1);
				    $query->orWhere("calificacion.estado",2);
				})->where("taller.idusuario", Auth::user()->id)
				->whereYear('calificacion.fecha_visita', '=', Input::get('year'))
				->orderBy('calificacion.fecha_visita',"DESC")
				->distinct()
				->select('calificacion.id','usuario.nombre','usuario.apellido','calificacion.descuento','calificacion.total','calificacion.fecha_visita','taller.nombre_taller')->get();
				$html = view('workshop.snippet.historialtable')->with(array('registros' => $result ))->render();
				return response()->json(array("success"=>1,'html' => $html ));
			}
			$result = DB::table('calificacion')
			->join('taller', 'calificacion.idtaller', '=', 'taller.id')
			->join('usuario', 'calificacion.idusuario', '=', 'usuario.id')
			->where(function ($query){
			    $query->where("calificacion.estado",1);
			    $query->orWhere("calificacion.estado",2);
			})->where("taller.idusuario", Auth::user()->id)
			->orderBy('calificacion.fecha_visita',"DESC")
			->distinct()
			->select('calificacion.id','usuario.nombre','usuario.apellido','calificacion.descuento','calificacion.total','calificacion.fecha_visita','taller.nombre_taller')->get();
			
			return view("workshop.historial",array('registros' => $result ));
		} catch (\Exception $e) {
			abort(500);
		}
		
	}
}