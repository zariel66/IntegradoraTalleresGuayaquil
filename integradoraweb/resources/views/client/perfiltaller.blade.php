@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-10 col-md-offset-1">
		<div class="panel-body">
			<div class="page-header">
		    	<h2><strong>{{$taller->nombre_taller}}</strong></h2>      
		  	</div>
		  	<div class="row">
		  		<div class="col-md-8">
		  			<div class="">
				  		<h4><strong>Información:</strong></h4> 
				  	</div>
		  			<div ><p>Dirección: {{$taller->direccion}}</p></div>
		  			<div ><p>
		  				Ofrecemos los siguientes servicios: 
		  				@foreach($taller->servicios as $fila)
		  				<span class="label label-default">{{$fila->categoria}}</span>
		  				
		  				@endforeach
		  			</p></div>
		  			<div ><p>
		  				Trabajamos con las siguientes marcas de vehículos:
		  				@foreach($taller->marcas as $fila)
		  				<span class="label label-default">{{$fila->nombre}}</span>
		  				
		  				@endforeach
		  			</p></div>
		  			<br>
		  			@if(count($taller->calificaciones->where('estado', 0)->where('idusuario',$idusuario))==0)
		  			<button id="contact-button" onclick="getContactInfo()" class="btn" style="background-color: #cdc0b7"><strong>Deseo ponerme en contacto</strong></button>
		  			<div id="contact-section">
		  				<div class="">
				  			<h4><strong>Contacto:</strong></h4> 
				  		</div>
		  				<p>Nombre del empleado: {{$taller->nombre_empleado}}</p>
		  				<p>Teléfono: {{$taller->telefono}}</p>
		  				<p>Al mostrar este código en el taller recibirá un descuento en el servicio:</p>
		  				<p id="discount-code"><span class="label label-default"></span></p>
		  			</div>
		  			@else
		  			
		  			<div>
		  				<div class="">
				  			<h4><strong>Contacto:</strong></h4> 
				  		</div>
		  				<p>Nombre del empleado: {{$taller->nombre_empleado}}</p>
		  				<p>Teléfono: {{$taller->telefono}}</p>
		  				<p>Al mostrar este código en el taller recibirá un descuento en el servicio:</p>
		  				<p id="discount-code"><span class="label label-default">{{$taller->calificaciones->where('estado', 0)->where('idusuario',$idusuario)->first()->desc_code}}</span></p>
		  			</div>
		  			@endif
		  		</div>
		  		<div class="col-md-4">
		  			@if(count($comentarios)>0)
		  			<div class="row">
		  				<div class="col-md-4">
		  					<div class="bar-label"><strong>Honestidad</strong></div>
		  					<div class="bar-label"><strong>Eficiencia</strong></div>
		  					<div class="bar-label"><strong>Costo</strong></div>
		  				</div>
		  				<div class="col-md-8">
		  					<div class="progress">
							    <div class="progress-bar 
							     @if($taller->honestidad <= 5)
							     low-grade
							     @elseif($taller->honestidad < 8)
							     medium-grade
							     @elseif($taller->honestidad <= 10)
							     high-grade
							     @endif
							     " role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:{{$taller->honestidad * 10}}%">
							      <span>
							     @if($taller->honestidad <= 5)
							     Poco confiable({{number_format($taller->honestidad, 2, '.', ',')}})
							     @elseif($taller->honestidad < 8)
							     Honrado({{number_format($taller->honestidad, 2, '.', ',')}})
							     @elseif($taller->honestidad <= 10)
							     Íntegro({{number_format($taller->honestidad, 2, '.', ',')}})
							     @endif
							     </span>
							    </div>
							</div>
							<div class="progress">
							    <div class="progress-bar 
							    @if($taller->eficiencia <= 5)
							     low-grade
							     @elseif($taller->eficiencia < 8)
							     medium-grade
							     @elseif($taller->eficiencia <= 10)
							     high-grade
							     @endif
							    " role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:{{$taller->eficiencia * 10}}%">
							     <span>
							     @if($taller->eficiencia <= 5)
							     Poco capacitado({{number_format($taller->eficiencia, 2, '.', ',')}})
							     @elseif($taller->eficiencia < 8)
							     Competente({{number_format($taller->eficiencia, 2, '.', ',')}})
							     @elseif($taller->eficiencia <= 10)
							     Eficiente({{number_format($taller->eficiencia, 2, '.', ',')}})
							     @endif
							     </span>
							    </div>
							</div>
							<div class="progress">
							    <div class="progress-bar  
							    @if($taller->precio <= 5)
							     low-grade
							     @elseif($taller->precio < 8)
							     medium-grade
							     @elseif($taller->precio <= 10)
							     high-grade
							     @endif
							     " role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:{{$taller->precio * 10}}%">
							     <span>
							     @if($taller->precio <= 5)
							     Caro({{number_format($taller->precio, 2, '.', ',')}})
							     @elseif($taller->precio < 8)
							     Moderado({{number_format($taller->precio, 2, '.', ',')}})
							     @elseif($taller->precio <= 10)
							     Económico({{number_format($taller->precio, 2, '.', ',')}})
							     @endif
							     </span>
							    </div>
							</div>
		  				</div>
		  				
		  			</div>
		  			@endif
		  			<br>
		  			<div class="row">
		  				<div id="map" style="width: 100%; height: 100%; max-height:300px;"></div>
		  			</div>
		  			
		  		</div>
		  	</div>
		  	<br>
		  	
		  	<hr>
		  	<div class="comment-section">
		  		<div class="">
		  			<h4><strong>Comentarios y evaluaciones del servicio:</strong></h4> 
		  		</div>
		  		<br>
		  		<div>
		  			@if(count($comentarios) >0)
		  			@foreach($comentarios as $calificacion)
		  			<div class="user-comment row">
		  				<div class="col-md-8">
		  					<p class="user-comment-username"><strong>{{$calificacion->user->username}}</strong> comento:</p>
		  					<p>{{$calificacion->comentario}}</p>
		  					<p class="date-comment text-left">{{$calificacion->fecha_hora}}</p>
		  				</div>
		  				<div class="col-md-2 col-md-offset-2">
		  					
		  					<div class="row">
				  				<div class="col-md-4">
				  					<div class="bar-label-mini"><strong>Honestidad</strong></div>
				  					<div class="bar-label-mini"><strong>Eficiencia</strong></div>
				  					<div class="bar-label-mini"><strong>Costo</strong></div>
				  				</div>
				  				<div class="col-md-8">
				  					<div class="progress mini-progress">
									    <div class="progress-bar 
									    @if($calificacion->honestidad <= 5)
									     low-grade
									     @elseif($calificacion->honestidad < 8)
									     medium-grade
									     @elseif($calificacion->honestidad <= 10)
									     high-grade
									     @endif
									    " role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:{{$calificacion->honestidad * 10}}%">
									     
									    </div>
									</div>
									<div class="progress mini-progress">
									    <div class="progress-bar  
									    @if($calificacion->eficiencia <= 5)
									     low-grade
									     @elseif($calificacion->eficiencia < 8)
									     medium-grade
									     @elseif($calificacion->eficiencia <= 10)
									     high-grade
									     @endif
									    " role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:{{$calificacion->eficiencia * 10}}%">
									     
									    </div>
									</div>
									<div class="progress mini-progress">
									    <div class="progress-bar 
									    @if($calificacion->precio <= 5)
									     low-grade
									     @elseif($calificacion->precio < 8)
									     medium-grade
									     @elseif($calificacion->precio <= 10)
									     high-grade
									     @endif
									    " role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:{{$calificacion->precio * 10}}%">
									    
									    </div>
									</div>
				  				</div>
				  				
				  			</div>
		  				</div>
		  			</div>
		  			@endforeach
		  			<div class="text-center">{{$comentarios->links()}}</div>
		  			@else

					<div class="alert alert-warning">
					  <strong>Este taller no ha sido evaluado por ningún usuario aún. Sé el primero y contáctate.</strong>
					</div>
		  			@endif
		  		</div>	
		  		
		  	</div>
		</div>
	</div>
</div>

			<style type="text/css">
				#form-section-background
				{
					width: 100%;
					margin: 0px;
					min-height: 700px;
					background-image:  url("{{ URL::asset('imagenes/icons/bgtool.jpg')}}");
					background-size: 300px 300px;
					padding: 5%;

				}
				#form-section-background .panel{
					border-radius: 25px;
					animation: fadein 2s;
				}

				.bar-label
				{
					margin-bottom: 20px;
				}
				.low-grade
				{
					background-image: linear-gradient(to bottom,#f90505 0,#770404 100%);
				}
				.medium-grade
				{
					background-image: linear-gradient(to bottom,#acb10c 0,#e4b509 100%);
				}
				.high-grade
				{
					background-image: linear-gradient(to bottom,#60f906 0,#2c940a 100%);
				}
				.user-comment
				{
					padding-top: 20px;
					padding-bottom: 20px;
					/*background-color: #f1e4dc;*/
					background-color: #e8f5f7;
					
					border: ridge 2px #e4e8e8;
				}
				.user-comment:hover
				{
					padding-top: 20px;
					padding-bottom: 20px;
					background-color:#e6e5e5;
					
					
					border: ridge 2px #afa6a6;
				}
				.user-comment-username
				{
					margin-bottom: 18px;
				}
				.date-comment
				{
					font-size: 9px;
				}
				.mini-progress
				{
					height: 13px;
					margin: 0;
				}
				.bar-label-mini
				{
					font-size: 9px;
				}
				.progress {
				    position: relative;
				}
				.progress span {
				    position: absolute;
				    display: block;
				    width: 100%;
				    color: black;
				    font-weight: bold;
				 }
				 #contact-section
				 {
				 	display: none;
				 }
				 #discount-code span
				 {
				 	font-size: 120%;
				 }
				 .pagination .active span,.pagination .active span:hover
				 {
				 	background-color: #333;
				 	border-color:#333;
				 }

			</style>
	<script type="text/javascript">
		function getContactInfo()
		{
			
			var values = {"idtaller":{{$taller->id}}};
			$("#contact-button").hide();
			var jqxhr = $.ajax({
				method: "POST",
				url: "/crearevaluacion",
				dataType: 'json',
				data: values,
				success: function(response)
				{
					if(response.success == 1){
						$("#discount-code span").html(response.desc_code);
						$("#contact-section").show();	
					}
					
				}
			});	
		}
	var marker;
	
	var map;
			
	function initMap() {
		var icono = {
					    url: "{{ URL::asset('imagenes/icons/tallericon.png')}}",
					    scaledSize: new google.maps.Size(35, 35), // scaled size
					    origin: new google.maps.Point(0,0), // origin
					    anchor: new google.maps.Point(0, 0) // anchor
					};
		var guayaquil = {lat: {{$taller->latitud}},lng: {{$taller->longitud}}};
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15,
			center: guayaquil,
			disableDefaultUI: true
		});
		marker = new google.maps.Marker({
						  position: guayaquil,
						  map: map,
						  title: "{{$taller->nombre_taller}}",
						  icon: icono
						});
	}
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMWnFVjp1hJEu6zTj5Y646z15ecr1WH7Q&callback=initMap">
	</script>	
@stop