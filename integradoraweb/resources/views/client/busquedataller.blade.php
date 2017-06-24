@extends("template")
@section("content")
<div id="form-section-background" class="container">
			<div class="panel col-md-10 col-md-offset-1">
				<div class="panel-body">
					
					<div class="row">
						<form>
							<div class="col-md-3">
								<label>Tipo de Taller Automotriz:</label>
								<select class="form-control">
									<option>Mecánico</option>
									<option>Electro-mecánico</option>
									<option>Tapizeria</option>
									<option>Vidrieria</option>
									<option>Pintura</option>
									<option>Carroceria</option>
								</select>
							</div>
							<div class="col-md-3 col-md-offset-2">
								<label>Vehiculo:</label>
								<select class="form-control">
									@foreach(Auth::user()->vehiculos as $v)
									<option value="{{$v->id}}">{{$v->modelo}}</option>
									@endforeach
									
								</select>
							</div>
							<div class="col-md-3 col-md-offset-1" style="margin-top:25px">
								<input type="submit" class="btn " value="Buscar">
							</div>
						</form>
					</div>
					<div class="row">
						<br>
						<div class="col-md-7">
							<div id="map" style="width: 100%; height: 100%; max-height:400px;"></div>
						</div>
						<div class="col-md-4 col-md-offset-1">
							<ul class="list-group" id="search-results">
								<a href="#" class="list-group-item align-items-start">
									<div class="justify-content-between">
									  <h4 class="mb-1">Nombre del taller</h4>
									  <small>Dirección del taller</small>
									</div>
									
							  </a>
							  <a href="#" class="list-group-item align-items-start">
									<div class="justify-content-between">
									  <h4 class="mb-1">Nombre del taller</h4>
									  <small>Dirección del taller</small>
									</div>
									
							  </a>
							  <a href="#" class="list-group-item align-items-start">
									<div class="justify-content-between">
									  <h4 class="mb-1">Nombre del taller</h4>
									  <small>Dirección del taller</small>
									</div>
									
							  </a>
							  <a href="#" class="list-group-item align-items-start">
									<div class="justify-content-between">
									  <h4 class="mb-1">Nombre del taller</h4>
									  <small>Dirección del taller</small>
									</div>
									
							  </a>
							  <a href="#" class="list-group-item align-items-start">
									<div class="justify-content-between">
									  <h4 class="mb-1">Nombre del taller</h4>
									  <small>Dirección del taller</small>
									</div>
									
							  </a>
							  <a href="#" class="list-group-item align-items-start">
									<div class="justify-content-between">
									  <h4 class="mb-1">Nombre del taller</h4>
									  <small>Dirección del taller</small>
									</div>
									
							  </a>
								
							</ul>
						</div>
					</div>
				</div>
			</div>
			<style type="text/css">
				#form-section-background
				{
					width: 100%;
					margin: 0px;
					height: 700px;
					background-image:  url("{{ URL::asset('imagenes/icons/bg2.jpg')}}");
					background-size: 300px 300px;
					padding: 5%;

				}
				#form-section-background .panel{
					border-radius: 25px;
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
			</style>
	<script>
	var marker;
	var posXY;
	var map;		
	function initMap() {
		var guayaquil = {lat: -2.1456078,lng: -79.9499721};
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15,
			center: guayaquil,
			disableDefaultUI: true
		});


		

	}

	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition, showError);
		} else { 
			alert("Geolocation is not supported by this browser.");
		}
	}

	function showPosition(position) {
	
		posXY = {lat: position.coords.latitude,lng:  position.coords.longitude};
	}

	function showError(error) {
		switch(error.code) {
			case error.PERMISSION_DENIED:
			alert("User denied the request for Geolocation.");
			break;
			case error.POSITION_UNAVAILABLE:
			alert("Location information is unavailable.");
			break;
			case error.TIMEOUT:
			alert("The request to get user location timed out.");
			break;
			case error.UNKNOWN_ERROR:
			alert("An unknown error occurred.");
			break;
		}
	}
	document.onload=getLocation(); 
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMWnFVjp1hJEu6zTj5Y646z15ecr1WH7Q&callback=initMap">
	</script>	
@stop