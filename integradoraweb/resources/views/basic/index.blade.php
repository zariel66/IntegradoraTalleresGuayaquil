@extends("template")
@section("content")
<div id="info-section-background"  class="container">
	<div class="panel panel-default col-md-offset-2 col-md-8">
		<div class="panel-body" id="cuerpopanel">
			<h1 class="text-center"><strong>{{config("constants.app_name")}}</strong></h3>
			<div class="row">
				<video  class="center-block" width="640" height="480" controls autoplay="autoplay" muted>
				  <source src="{{URL::asset('video/geocarfix.mp4')}}" type="video/mp4">
				  
				  Tu navegador no soporta formato mp4
				</video>
			</div>
			<br>
			<hr>
			<div class="row">
				<div class="col-md-6">
					<article>
						<h4><strong>¿Para qué sirve?</strong></h5>
						<p class="text-justify">Al usar nuestra aplicación puede acceder de forma gratuita a información de talleres cercanos a usted ubicados en Guayaquil que ofrecen servicios de mantenimiento y reparación vehicular. Tan solo requiere un dispositivo con internet o gps y buscaremos por usted el taller que necesita de acuerdo a la marca de su vehículo. Los servicios ofrecidos por los talleres en nuestra plataforma son:</p>
						<br>
						<div class="col-md-4 col-md-offset-2">
							<ul class="text-left" style="list-style-type:disc;padding-left:0;">
							  <li>Carrocería</li>
							  <li>Electromecánico</li>
							  <li>Mecánico</li>
							  <li>Pintado</li>
							  <li>Tapicería</li>
							  <li>Vidriería</li>
							</ul>  
						</div>
					</article>
					
					
				</div>
				<div class="col-md-6">
					<img alt="servicios ofrecidos" class="center-block" src="{{ URL::asset('imagenes/icons/servicios.jpg')}}" style="width:300px;height:300px;">
				</div>
			</div>
			<br><br>
			<hr>
			<br>
			<div class="row">
				
				<div class="col-md-6">
					<img alt="calidad servicio" class="center-block" src="{{ URL::asset('imagenes/icons/quality.png')}}" style="width:300px;height:300px;">
				</div>
				<div class="col-md-6">
					<article>
						<h4><strong>¿Es confiable?</strong></h5>
						<p class="text-justify">Todos los talleres registrados en la plataforma pasan por un proceso de evaluación que brinda información valiosa de la calidad de los servicios ofrecidos. También puede consultar las recomendaciones de otros usuarios los cuales evalúan tres criterios que miden la calidad del servicio proporcionado como:</p>
						<br>
						<div class="col-md-4 col-md-offset-2">
							<ul class="text-left" style="list-style-type:disc;padding-left:0;">
							  <li>Honestidad</li>
							  <li>Eficiencia</li>
							  <li>Costo</li>
							  
							</ul>  
						</div>
					</article>
				</div>
			</div>
			<br><br>
			<hr>
			<br>
			<div class="row">
				<div class="col-md-6">
					<article>
						<h4><strong>¿Cómo acceder a nuestros servicios?</strong></h5>
						<p class="text-justify">Si desea hacer uso de los servicios  de la aplicación para ubicar el taller que necesita su vehículo tan solo debe <a href="{{url('registrocliente')}}">registrarse</a>. Ingresando sus datos, la marca y modelo de su vehículo a la plataforma podrá recibir todos nuestros beneficios sin ningún costo entre los cuales se encuentran:</p>
						<br>
						<div class="col-md-10 col-md-offset-2">
							<ul class="text-left" style="list-style-type:disc;padding-left:0;">
							  <li>Acceso a información de talleres automotrices en la ciudad de Guayaquil.</li>
							  <li>Descuentos en los costos de los servicios por el uso de nuestra aplicación.</li>
							  <li>Información detallada de la calidad de los servicios de cada taller automotriz.</li>
							  
							</ul>  
						</div>
					</article>
				</div>
				<div class="col-md-6">
					<img class="center-block" src="{{ URL::asset('imagenes/icons/userservice.png')}}" style="width:300px;height:300px;">
				</div>
				
			</div>
			<br><br>
			<hr>
			<br>
			<div class="row">
				
				<div class="col-md-6">
					<img class="center-block" src="{{ URL::asset('imagenes/icons/autoshop.png')}}" style="width:300px;height:300px;">
				</div>
				<div class="col-md-6">
					<article>
						<h4><strong>¿Es propietario de un taller automotriz?</strong></h5>
						<p class="text-justify">Si usted es dueño de un taller automotriz en Guayaquil y desea darse a conocer, <a href="{{url('registrartaller')}}">regístrese</a> en nuestra plataforma de forma gratuita. Podrá adquirir nuevos clientes interesados en sus servicios y crecerá dentro de la plataforma de acuerdo a sus méritos solo debe registrar los siguientes datos: </p>
						<br>
						<div class="col-md-10 col-md-offset-2">
							<ul class="text-left" style="list-style-type:disc;padding-left:0;">
							  <li>Información de contacto para sus nuevos clientes.</li>
							  <li>Información de los servicios que brinda en su taller.</li>
							  <li>Las marcas con las que trabaja su establecimiento.</li>
							  
							</ul>  
						</div>
					</article>
				</div>
			</div>
			<br><br>
		</div>
	</div>
</div>

<style type="text/css">

#info-section-background
{
	width: 100%;
	background-image: url("{{ URL::asset('imagenes/icons/bg2.jpg')}}");
	background-color: #cccccc;
	 background-repeat: repeat-y;
	background-size: 100% 700px;
	min-height: 1000px;
	padding-bottom: 5%;
	padding-top: 5%;


}
 #cuerpopanel
 {
 	font-size: 110%;
 }


@media only screen and (min-width: 640px) and (max-width: 1190px) {
   #register-section-background
	{
		
		min-height:85vh;
		
		padding-top: 20vh;


	}
	
}

</style>
@stop
