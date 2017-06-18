<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
   public function index()
   {
        return view("basic.home");
   }
   public function registrarTaller()
   {    
        return view("basic.registerworkshop");
   }
}