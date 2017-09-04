@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-10 col-md-offset-1">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6 text-left">
					<h1><strong>Buscar Taller</strong></h1>
				</div>
				
			</div>
			<hr>
			
			<div class="row">
				<!-- <form> -->
					<div class="col-md-3">
						<label>Tipo de Taller Automotriz:</label>
						<select class="form-control" id="serviceselect">
							
							<option value="Mecánico">Mecánico</option>
							<option value="Electromecánico">Electromecánico</option>
							<option value="Carrocería">Carrocería</option>
							<option value="Pintado">Pintado</option>
							<option value="Tapicería">Tapicería</option>
							<option value="Vidriería">Vidriería</option>
						</select>
					</div>
					<div class="col-md-3 col-md-offset-2">
						<label>Tú Vehículo:</label>
						<select class="form-control" id="carselect">
							@foreach(Auth::user()->vehiculos as $v)
							<option value="{{$v->idmarca}}">{{$v->modelo}} ({{$v->marca->nombre}})</option>
							@endforeach
							
						</select>
					</div>
					<div class="col-md-3 col-md-offset-1" style="margin-top:25px">
						<button class="btn" id="search-btn" onclick="searchWorkshops(30)"><span class="glyphicon glyphicon-search"></span> Buscar Taller</button>
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


		#search-results
		{
			cursor: pointer;
			overflow-y: scroll;
			max-height: 400px;
			min-height: 350px;
			border-style: double;
		}
		#search-results a:hover
		{
			background-color:#cdc0b7;
		}
		
		#search-btn
		{
			background-color: #f3d3be;
			font-weight: bold;
			width: 150px;
			
		}
		#search-btn:hover
		{
			animation-name: btnbgtrans;
			animation-duration: 1s;
			-webkit-animation-fill-mode: forwards;
			animation-fill-mode: forwards;
	    		
		}
		@media only screen and (min-width: 640px) and (max-width: 1190px) {
		   #form-section-background
			{
				
				min-height:85vh;
				
				padding-top: 12vh;
			}
			
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
			zoom: 13,
			center: guayaquil,
			disableDefaultUI: true,
			zoomControl: true,
		});

		google.maps.event.addListener(map, 'click', function( event ){
			
			var lati =  event.latLng.lat();
			var longi = event.latLng.lng();
			posXY = {lat: lati,lng:longi};
			if(marker != null)
			{
				marker.setMap(null);
			}
			marker = new google.maps.Marker({
				  position: posXY,
				  map: map
				});
			map.panTo(posXY);
			
		});
		if (typeof(window.localStorage) !== "undefined") {
		    if (window.localStorage.getItem("resultadosbusqueda") !== null) {
				$("#search-results").html(window.localStorage.getItem("resultadosbusqueda"));
				var talleres= JSON.parse(window.localStorage.getItem("marcadores"));
				var servicio= window.localStorage.getItem("servicio");
				var car= window.localStorage.getItem("car");
				var lat= window.localStorage.getItem("lat");
				var lng= window.localStorage.getItem("lng");
				var icono = {
					    url: "{{ URL::asset('imagenes/icons/tallericon.png')}}",
					    scaledSize: new google.maps.Size(35, 35), // scaled size
					    origin: new google.maps.Point(0,0), // origin
					    anchor: new google.maps.Point(0, 0) // anchor
					};
				for (var i = 0; i < talleres.length; i++) {
					var workshoposXY = new google.maps.Marker({
						  position: {lat: talleres[i].latitud,lng: talleres[i].longitud},
						  map: map,
						  title: talleres[i].nombre_taller,
						  icon: icono,
						  url: "perfiltaller/" + talleres[i].id + "/" + lat + "/" + lng + "/" + servicio + "/" + car,
						  id: talleres[i].id
						});
					google.maps.event.addListener(workshoposXY, 'click', function() {
						    window.location.href = this.url;
						});
					markers.push(workshoposXY);
				}
			}
		} 

	}

	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition, showError,{timeout:30000, enableHighAccuracy: true});
		} else { 
			alert("Geolocalización no es soportada por tu navegador.");
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
			alert("El usuario nego el permiso de Geolocalización.");
			break;
			case error.POSITION_UNAVAILABLE:
			alert("La información de la ubicación no esta disponible.");
			break;
			case error.TIMEOUT:
			alert("La petición expiró");
			break;
			case error.UNKNOWN_ERROR:
			alert("Un error desconocido ocurrio.");
			break;
		}
	}

	function searchWorkshops(distancia)
	{
		//var distancia = 5;
		var servicio = $("#serviceselect").val();
		var car = $("#carselect").val();
		var values = {"servicio":servicio, "vehiculo":car, "latitude": posXY.lat ,"longitude": posXY.lng, "distancia" : distancia};
		var jqxhr = $.ajax({
			method: "POST",
			url: "busquedataller",
			dataType: 'json',
			data: values,
			success: function(response)
			{
				setMapOnAll(null);
				$("#search-results").html(response.html);
				
				if(response.success != 0)
				{
					
					var workshops = response.workshops;
					
					var icono = {
					    url: "{{ URL::asset('imagenes/icons/tallericon.png')}}",
					    scaledSize: new google.maps.Size(35, 35), // scaled size
					    origin: new google.maps.Point(0,0), // origin
					    anchor: new google.maps.Point(0, 0) // anchor
					};
					for (var i = 0; i < workshops.length; i++) {
						var workshoposXY = new google.maps.Marker({
						  position: {lat: workshops[i].latitud,lng: workshops[i].longitud},
						  map: map,
						  title: workshops[i].nombre_taller,
						  icon: icono,
						  url: "perfiltaller/" + workshops[i].id + "/" + posXY.lat + "/" + posXY.lng + "/" + servicio + "/" + car,
						  id: workshops[i].id
						});
						markers.push(workshoposXY);
						google.maps.event.addListener(workshoposXY, 'click', function() {
						    window.location.href = this.url;
						});
					};
					if (typeof(window.localStorage) !== "undefined") {
					    window.localStorage.setItem("resultadosbusqueda", response.html );
					    window.localStorage.setItem("marcadores", JSON.stringify(workshops) );
					    window.localStorage.setItem("lat", posXY.lat);
					    window.localStorage.setItem("lng", posXY.lng);
					    window.localStorage.setItem("servicio", servicio);
					    window.localStorage.setItem("car", car);
					} 
				}
				else
				{
					if(distancia >= 15)
					{
						$("#search-results").html(response.html);
						return;
					}
					searchWorkshops(distancia + 1);
				}
				
				
			}
		});

	}

	function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

    function redicon(id)
    {
    	var icono = {
			    url: "{{ URL::asset('imagenes/icons/tallericon2.png')}}",
			    scaledSize: new google.maps.Size(35, 35), // scaled size
			    origin: new google.maps.Point(0,0), // origin
			    anchor: new google.maps.Point(0, 0) // anchor
			};
		var icono2 = {
			    url: "{{ URL::asset('imagenes/icons/tallericon.png')}}",
			    scaledSize: new google.maps.Size(35, 35), // scaled size
			    origin: new google.maps.Point(0,0), // origin
			    anchor: new google.maps.Point(0, 0) // anchor
			};
    	for (var i = 0; i < markers.length; i++) {
    		markers[i].setIcon(icono2);
    		if(markers[i].id == id)
    		{
    			markers[i].setIcon(icono);
    		}
          
        }

    } 


	document.onload=getLocation(); 
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMWnFVjp1hJEu6zTj5Y646z15ecr1WH7Q&callback=initMap">
	</script>	
@stop