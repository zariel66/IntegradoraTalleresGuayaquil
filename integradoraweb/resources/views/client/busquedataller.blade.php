@extends("template")
@section("content")
<div id="form-section-background" class="container">
			<div class="panel col-md-10 col-md-offset-1">
				<div class="panel-body">
					
					<div class="row">
						<!-- <form> -->
							<div class="col-md-3">
								<label>Tipo de Taller Automotriz:</label>
								<select class="form-control" id="serviceselect">
									<option value="Carrocería">Carrocería</option>
									<option value="Electromecánico">Electromecánico</option>
									<option value="Mecánico">Mecánico</option>
									<option value="Pintado">Pintado</option>
									<option value="Tapicería">Tapicería</option>
									<option value="Vidriería">Vidriería</option>
								</select>
							</div>
							<div class="col-md-3 col-md-offset-2">
								<label>Vehiculo:</label>
								<select class="form-control" id="carselect">
									@foreach(Auth::user()->vehiculos as $v)
									<option value="{{$v->idmarca}}">{{$v->modelo}}</option>
									@endforeach
									
								</select>
							</div>
							<div class="col-md-3 col-md-offset-1" style="margin-top:25px">
								<button class="btn" onclick="searchWorkshops()">Buscar Taller</button>
							</div>
						<!-- </form> -->
					</div>
					<br>
					<br>
					<div class="row">
						<br>
						<div class="col-md-7">
							<div id="map" style="width: 100%; height: 100%; max-height:450px;"></div>
						</div>
						<div class="col-md-4 col-md-offset-1">
							<div class=""><strong>Resultados de la búsqueda:</strong></div>
							<br>
							<ul class="list-group" id="search-results">
								
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
					min-height: 700px;
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
					min-height: 350px;
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
	var markers = [];		
	function initMap() {
		var guayaquil = {lat: -2.1456078,lng: -79.9499721};
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 18,
			center: guayaquil,
			disableDefaultUI: true
		});


		

	}

	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition, showError,{timeout:30000, enableHighAccuracy: true});
		} else { 
			alert("Geolocation is not supported by this browser.");
		}
	}

	function showPosition(position) {
	
		posXY = {lat: position.coords.latitude,lng:  position.coords.longitude};
		if (typeof google === 'object' && typeof google.maps === 'object')
		{
			if(marker != null)
			{
					marker.setMap(null);
			}
			marker = new google.maps.Marker({
				  position: posXY,
				  map: map
				});
			map.panTo(posXY);
		}
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

	function searchWorkshops()
	{
		
		var servicio = $("#serviceselect").val();
		var car = $("#carselect").val();
		var values = {"servicio":servicio, "vehiculo":car, "latitude": posXY.lat ,"longitude": posXY.lng};
		var jqxhr = $.ajax({
			method: "POST",
			url: "busquedataller",
			dataType: 'json',
			data: values,
			success: function(response)
			{
				setMapOnAll(null);
				var workshops = response.workshops;
				$("#search-results").html(response.html);
				var icono = {
				    url: "{{ URL::asset('imagenes/icons/tallericon.png')}}",
				    scaledSize: new google.maps.Size(30, 30), // scaled size
				    origin: new google.maps.Point(0,0), // origin
				    anchor: new google.maps.Point(0, 0) // anchor
				};
				for (var i = 0; i < workshops.length; i++) {
					var workshoposXY = new google.maps.Marker({
					  position: {lat: workshops[i].latitud,lng: workshops[i].longitud},
					  map: map,
					  title: workshops[i].nombre_taller,
					  icon: icono
					});
					markers.push(workshoposXY);
				};
				
			}
		});

	}

	function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

	document.onload=getLocation(); 
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMWnFVjp1hJEu6zTj5Y646z15ecr1WH7Q&callback=initMap">
	</script>	
@stop