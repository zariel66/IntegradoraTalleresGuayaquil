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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
class WorkshopController extends Controller
{
	public function __construct()
	{
		// $this->middleware('myauth');
		//$this->middleware('sslp');
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
		// error_log($current);
		//var_dump($result->first());
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
			$calificacion = Calificacion::find($id);
			$calificacion->update(
			[
			    "precio_original"=> $precio,
			    "descuento"=> $descuento,
			    "total"=> $total,
			    "estado" => 2,
			    'fecha_hora' => \Carbon\Carbon::now()
			]);
			$output = "<strong>El código de la transacción ha sido confirmado. El usuario evaluará la calidad del servicio en los próximos días</strong>";
			Mail::send('emails.reminder', ['calificacion' => $calificacion], function ($m) use ($calificacion) {
	            $m->from(config("constants.emails.from"), config("constants.app_name"));

	            $m->to($calificacion->user->correo, $calificacion->user->nombre)->subject('Ayúdanos evaluando la calidad del servicio');
	        });
		} catch (\Exception $e) {
			throw $e;
			
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
}