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
		$marcas = DB::table('marca')->orderBy("nombre","ASC")->get();
		return view("client.busquedataller",array('marcas' => $marcas, ));
	}

	
}
