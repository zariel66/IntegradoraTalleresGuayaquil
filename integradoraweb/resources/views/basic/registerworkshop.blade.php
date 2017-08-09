@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-10 col-md-offset-1">
		<div class="panel-body">
			<div class="row">
				<h2 style="font-weight:bold;">Registro del Taller</h2>
			</div>
			
			<div class="row">
				<br>
				<form class="form-inline" action="registrotallersubmit" method="POST" autocomplete="on">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="row">
						<div class="col-md-2">
							<label>Nombres(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="100" value="{{old('nombre')}}" class="form-control" type="text" name="nombre"
							@if($errors->has('nombre'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('nombre') }}</small></div>
						</div>
						<div class="col-md-2 col-md-offset-1">
							<label>Correo(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="100" value="{{old('correo')}}" class="form-control" type="text" name="correo"
							@if($errors->has('correo'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('correo') }}</small></div>
							
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-2">
							<label>Apellidos(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="100" value="{{old('apellido')}}" class="form-control" type="text" name="apellido"
							@if($errors->has('apellido'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('apellido') }}</small></div>
						</div>
						<div class="col-md-2 col-md-offset-1">
							<label>Nombre del taller(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="100" value="{{old('nombre_taller')}}" class="form-control" type="text" name="nombre_taller"
							@if($errors->has('nombre_taller'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('nombre_taller') }}</small></div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-2">
							<label>Usuario(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="32" value="{{old('username')}}" class="form-control" type="text" name="username"
							@if($errors->has('username'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('username') }}</small></div>
						</div>
						<div class="col-md-2 col-md-offset-1">
							<label>Dirección(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="100" value="{{old('direccion')}}" type="text" class="form-control" name="direccion"
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
							<label>Contraseña(*): </label>
						</div>
						<div class="col-md-3">
							<input  maxlength="100" value="{{old('password')}}" class="form-control" type="password" name="password"
							@if($errors->has('password'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('password') }}</small></div>
						</div>
						<div class="col-md-2 col-md-offset-1">
							<label>Teléfono del establecimiento(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="50" value="{{old('telefono')}}" class="form-control" type="text" name="telefono"
							@if($errors->has('telefono'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('telefono') }}</small></div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-2">
							<label>Confirmar Contraseña(*):</label>
						</div>
						<div class="col-md-3">
							<input maxlength="100" class="form-control" type="password" name="password_confirmation"
							@if($errors->has('password_confirmation'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('password_confirmation') }}</small></div>
							
						</div>
						<div class="col-md-2 col-md-offset-1">
							<label>Nombre completo del empleado a cargo(*): </label>
						</div>
						<div class="col-md-3">
							<input maxlength="100" value="{{old('nombre_empleado')}}" class="form-control" type="text" name="nombre_empleado"
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
								<div class="list-group-item">
									<input type="checkbox" value="{{$marca->id}}" name="marcas[]"> {{$marca->nombre}}
								</div>
								@endforeach
								
							</ul>
							<div style="color:red"><small>{{ $errors->first('marcas') }}</small></div>
						</div>

						<div class="col-md-2 col-md-offset-1">
							<label>Seleccione los servicios que ofrece su taller(*):</label>
						</div>
						<div class="col-md-3">
							<ul class="list-group checkbox-list" >
								<div  class="list-group-item">
									<input type="checkbox" value="Carrocería" name="servicios[]"> Carrocería
								</div>
								<div  class="list-group-item">
									<input type="checkbox"  value="Electromecánico" name="servicios[]"> Electromecánico
								</div>
								<div  class="list-group-item">
									<input type="checkbox" value="Mecánico" name="servicios[]"> Mecánico
								</div>
								<div  class="list-group-item">
									<input type="checkbox" value="Pintado" name="servicios[]"> Pintado
								</div>
								<div  class="list-group-item">
									<input type="checkbox" value="Tapicería" name="servicios[]"> Tapicería
								</div>
								<div  class="list-group-item">
									<input type="checkbox" value="Vidriería" name="servicios[]"> Vidriería
								</div>
							</ul>
							<div style="color:red"><small>{{ $errors->first('servicios') }}</small></div>
						</div>
					</div>
					<br>
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
					<input type="hidden" name="lat">
					<input type="hidden" name="lon">
					<div class="row">
						<div class="col-md-3">
							<input id="submitRegistro" class="btn register-buttons" type="submit" value="Registrar" disabled>
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
		padding-left: 80px;
		animation: fadein 2s;
	}

	#search-results
	{
		cursor: pointer;
		overflow-y: scroll;
		max-height: 400px;
	}
	#search-results a:hover
	{
		background-color:#cdc0b7;
	}

	.register-buttons
	{
		width: 150px;
		
		font-weight:bold;
		color: #373737;
		background-color:#f3d3be;

	}
	.checkbox-list
	{
		max-height: 120px;
		overflow-y:scroll;
	}
</style>
<script>
  function initMap() {
	var guayaquil = {lat: -2.1456078,lng: -79.9499721};
	var map = new google.maps.Map(document.getElementById('map'), {
	  zoom: 15,
	  center: guayaquil,
	  disableDefaultUI: true
	});
	  
	
	var marker;
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
		$('#submitRegistro').prop("disabled", false);

		//alert( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() ); 
	});
 }
  
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMWnFVjp1hJEu6zTj5Y646z15ecr1WH7Q&callback=initMap">
</script>
@stop