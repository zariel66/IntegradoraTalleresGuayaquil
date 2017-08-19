<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Marca;
use App\Taller;
use App\Calificacion;
use App\Vehiculo;
use Faker\Factory as Faker;
class UnitarioTest extends TestCase
{
    //use DatabaseTransactions;
    
    /**
     * @group home
     * 
     */
    public function testHome()
    {
        $response = $this->get('/');
        error_log("Home page");
       	$response->assertStatus(200);
    }
    /**
     * @group 
     * 
     */
    public function testLoginCommonUser()
    {
    	$inputs = ["username"=> "dlaaz","password"=>"demo1234"];
        $response = $this->post('iniciarsesion',$inputs);
        error_log("Login User");
       	$response->assertRedirect("busquedataller");

    }
    /**
     * @group access
     * 
     */
    public function testLoginWorkshopUser()
    {
    	$inputs = ["username"=> "taller","password"=>"demo1234"];
        $response = $this->post('iniciarsesion',$inputs);
        error_log("Login Workshop");
       	$response->assertRedirect("tallertickets");

    }
    /**
     * @group registro
     * 
     */
    public function testRegistroTaller()
    {
        
        $faker = Faker::create();
        $username = $faker->firstName;
    	$inputs = array(
			'nombre' => 'Test Case',
			'apellido' => 'Test Case',
			'username' => $username,
            //'username' => 'dlaaz',
			'correo' => $faker->email,
			'password' => 'test1234',
			'password_confirmation' => 'test1234',
			'direccion' => 'direccion prueba',
			'telefono' => '0982472750',
			'nombre_empleado' => 'Empleado Test',
			"marcas" => array(1,2,11),
            //"marcas" => array(),
			"servicios" => array("Carrocería","Mecánico"),
			"nombre_taller" => "NOMBRE TALLER TEST",
            "lat"=> "-2.162321974048685",
            "lon"=> "-79.90681394934654"
			);

    	$response = $this->post('registrotallersubmit',$inputs);
    	error_log("Register Workshop");
        error_log("UNIT TEST: username:" . $username);
       	$response->assertRedirect("tallertickets");

    }

    /**
     * @group registroi
     * 
     */
    public function testIntegracionRegistroTaller()
    {
        $user = User::find(21);
        $taller = Taller::all()->last();
        error_log("Integracion Registro Taller");

        $response = $this->actingAs($user)->get('perfiltaller/' . $taller->id);

        $response->assertStatus(200)->assertViewIs("client.perfiltaller");
        error_log("UNIT TEST: Taller encontrado: " . $taller->nombre_taller);
    }
    /**
     * @group busqueda
     * 
     */
    public function testBusquedaTaller()
    {
        $inputs = array(
            'servicio' => 'Carrocería',
            'vehiculo' => '11',
            //NORTE
            // 'latitude' => '-2.0655768893565587',
            // 'longitude' => '-79.92849223315716',
            //CENTRO
            'latitude' => '-2.162321974048685',
            'longitude' => '-79.90681394934654',
            'distancia' => '10',
            
            );
        $response = $this->post('busquedataller',$inputs);
        error_log("Search Workshop");
        $response->assertJson(["success"=>1])->assertStatus(200);

    }
    /**
     * @group comments1
     * 
     */
    public function testNuevaEvaluacionEtapa1()
    {
       //user = User::where("tipo",2)->inRandomOrder()->first();
        $user = User::find(21);
        $inputs = array(
             'idtaller' =>  Taller::inRandomOrder()->first()->id,
             //'idtaller' =>  ,
            );

        $response = $this->actingAs($user)->post('crearevaluacion',$inputs);
        error_log("Step 1 Evaluation");
        $response->assertJson(["success"=>1])->assertJsonFragment(["desc_code"])->assertStatus(200);

    }
    /**
     * @group comments2
     * 
     */
    public function testNuevaEvaluacionEtapa2()
    {
        $user = User::where("tipo",1)->inRandomOrder()->first();
        $inputs = array(
            'id' =>  Calificacion::where("estado",0)->inRandomOrder()->first()->id,
            'precio'=> 50,
            'descuento'=>100,
            'total' =>40,
            );
        $response = $this->actingAs($user)->post('cerrarticket',$inputs);
        error_log("Step 2 Evaluation");

        $response->assertJson(["success"=>1])->assertStatus(200);
    }

    /**
     * @group comments3
     * 
     */
    public function testNuevaEvaluacionEtapa3()
    {
        $calificacion = Calificacion::where("estado",2)->inRandomOrder()->first();
        
        $inputs = array(
            'honestidad' => 11 ,
            'precio'=> 0,
            'eficiencia'=>1,
            'comentario' => "",
            'idcalificacion' => $calificacion->id,
            );
        $response = $this->post('evaluacionservicio',$inputs);
        error_log("Step 3 Evaluation");
        $response->assertRedirect("perfiltaller/" . $calificacion->taller->id);
    }

    /**
     * @group comments
     * 
     */
    public function testNuevaEvaluacionIntegracion()
    {
        $this->assertDatabaseHas('calificacion', [
            'comentario' => 'Esto es un comentario de testing'
        ]);
    }
}
