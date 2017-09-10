@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-10 col-md-offset-1">
		<div class="panel-body">
			<div class="row">
				<div class="text-left">
					<h1><strong>Editar Taller</strong></h1>
				</div>
				
			</div>
			<hr>
			<div class="row">
				<form  class="form-inline" autocomplete="on" method="POST" action="{{url('editartaller')}}/{{$taller->id}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="row">
						<div class="col-md-2">
							<label>Nombre del taller(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="100" class="form-control" name="nombre_taller" type="text" value="{{ !empty(old('nombre_taller'))? old('nombre_taller') : $taller->nombre_taller}}"
							@if($errors->has('nombre_taller'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('nombre_taller') }}</small></div>
						</div>
						<div class="col-md-2 col-md-offset-1">
							<label>Dirección(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="100" class="form-control" name="direccion" type="text" value="{{ !empty(old('direccion'))? old('direccion') : $taller->direccion}}"
							@if($errors->has('direccion'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('direccion') }}</small></div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-2">
							<label>Teléfono del establecimiento(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="11" class="form-control" name="telefono" type="text" value="{{!empty(old('telefono'))? old('telefono') : $taller->telefono}}"
							@if($errors->has('telefono'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('telefono') }}</small></div>
						</div>
						<div class="col-md-2 col-md-offset-1">
							<label>Nombre del maestro(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="100" class="form-control" name="nombre_empleado" type="text" value="{{!empty(old('nombre_empleado'))? old('nombre_empleado') : $taller->nombre_empleado}}"
							@if($errors->has('nombre_empleado'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('nombre_empleado') }}</small></div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-2">
							<label>Seleccione las marcas de vehículos en que se especializa su taller(*):</label>
						</div>
						<div class="col-md-3">
							<ul class="list-group checkbox-list" >
								@foreach($marcas as $marca)
									@if($taller->marcas->contains($marca))
									<div class="list-group-item">
										<input checked="true" type="checkbox"value="{{$marca->id}}" name="marcas[]"> {{$marca->nombre}}
									</div>
									@else
									<div class="list-group-item">
										<input type="checkbox" value="{{$marca->id}}" name="marcas[]"> {{$marca->nombre}}
									</div>
									@endif	
								@endforeach
							</ul>
							<div style="color:red"><small>{{ $errors->first('marcas') }}</small></div>
						</div>

						<div class="col-md-2 col-md-offset-1">
							<label>Seleccione los servicios que ofrece su taller(*):</label>
						</div>
						<div class="col-md-3">
							<ul class="list-group checkbox-list" >
								
								@if($taller->servicios->contains("categoria","Mecánico"))
								<div  class="list-group-item">
									<input checked="true" type="checkbox" value="Mecánico" name="servicios[]"> Mecánico
								</div>
								@else
								<div  class="list-group-item">
									<input type="checkbox" value="Mecánico" name="servicios[]"> Mecánico
								</div>
								@endif
								@if($taller->servicios->contains("categoria","Electromecánico"))
								<div  class="list-group-item">
									<input checked="true" type="checkbox"  value="Electromecánico" name="servicios[]"> Electromecánico
								</div>
								@else
								<div  class="list-group-item">
									<input type="checkbox"  value="Electromecánico" name="servicios[]"> Electromecánico
								</div>
								@endif
								@if($taller->servicios->contains("categoria","Carrocería"))
								<div  class="list-group-item">
									<input checked="true" type="checkbox" value="Carrocería" name="servicios[]"> Carrocería
								</div>
								@else
								<div  class="list-group-item">
									<input type="checkbox" value="Carrocería" name="servicios[]"> Carrocería
								</div>
								@endif
								@if($taller->servicios->contains("categoria","Pintado"))
								<div  class="list-group-item">
									<input checked="true" type="checkbox" value="Pintado" name="servicios[]"> Pintado
								</div>
								@else
								<div  class="list-group-item">
									<input type="checkbox" value="Pintado" name="servicios[]"> Pintado
								</div>
								@endif
								@if($taller->servicios->contains("categoria","Tapicería"))
								<div  class="list-group-item">
									<input checked="true" type="checkbox" value="Tapicería" name="servicios[]"> Tapicería
								</div>
								@else
								<div  class="list-group-item">
									<input type="checkbox" value="Tapicería" name="servicios[]"> Tapicería
								</div>
								@endif
								@if($taller->servicios->contains("categoria","Vidriería"))
								<div  class="list-group-item">
									<input checked="true" type="checkbox" value="Vidriería" name="servicios[]"> Vidriería
								</div>
								@else
								<div  class="list-group-item">
									<input type="checkbox" value="Vidriería" name="servicios[]"> Vidriería
								</div>
								@endif
							</ul>
							<div style="color:red"><small>{{ $errors->first('servicios') }}</small></div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<label>Indique la ubicación de su taller en el mapa(*): </label>
						</div>
						<div >
							<div id="map" class="col-md-10" style="min-height:400px;"></div>
						</div>
					</div>
					<br>
					<input type="hidden" name="lat" value="{{$taller->latitud}}">
					<input type="hidden" name="lon" value="{{$taller->longitud}}">
					<div class="row">
						<div class="col-md-3">
							<input id="submitRegistro" class="btn register-buttons" type="submit" value="Guardar Cambios">
						</div>

					</div>
				</form>
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
			padding-left: 80px;
		}


	
		#search-btn:hover
		{
			animation-name: btnbgtrans;
			animation-duration: 1s;
			-webkit-animation-fill-mode: forwards;
			animation-fill-mode: forwards;
	    		
		}
		#user-info
		{
			padding-left: 25px;
			border:ridge 2px #e4e8e8;
			/*background-color: #f2f9f7;*/
			background-color:#e8f5f7;
		}
		#user-cars
		{
			padding-left: 25px;
		}

		.checkbox-list
		{
			max-height: 120px;
			overflow-y:scroll;
		}
		.register-buttons
		{
			width: 150px;
			
			font-weight:bold;
			color: #373737;
			background-color:#cdc0b7;

		}

		@media only screen and (min-width: 640px) and (max-width: 1190px) {
		   #form-section-background
			{
				
				min-height:85vh;
				
				padding-top: 12vh;
			}
			
		}
	</style>
	<script type="text/javascript">
	function initMap() {
		var marker;
		var guayaquil = {lat: {{$taller->latitud}},lng: {{$taller->longitud}}};
		var map = new google.maps.Map(document.getElementById('map'), {
		  zoom: 15,
		  center: guayaquil,
		  disableDefaultUI: true
		});
		marker = new google.maps.Marker({
			  position: guayaquil,
			  map: map
			});
		  
		
		
		google.maps.event.addListener(map, 'click', function( event ){
			if(marker != null)
			{
				marker.setMap(null);
			}
			var lati =  event.latLng.lat();
			var longi = event.latLng.lng();
			marker = new google.maps.Marker({
			  position: {lat: lati,lng: longi},
			  map: map
			});
			$('input[name="lat"]').val(lati);
			$('input[name="lon"]').val(longi);

			//alert( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() ); 
		});
	 }
	 $("input[name=telefono]").keydown(function(e) {
		var oldvalue=$(this).val();
		var field=this;
		 setTimeout(function () {
			
			var patt = /^\(04\)[0-9]*$/;
			var res = patt.test(field.value);
		    if(field.value.indexOf('(04)') !== 0) {
		        $(field).val(oldvalue);
		        
		    }
		    else if(!res)
		    {
		    	$(field).val(oldvalue);
		    	
		    } 
		    
		 }, 1);
	});
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMWnFVjp1hJEu6zTj5Y646z15ecr1WH7Q&callback=initMap">
	</script>
@stop