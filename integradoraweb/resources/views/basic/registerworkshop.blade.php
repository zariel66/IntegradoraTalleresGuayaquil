@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-10 col-md-offset-1">
		<div class="panel-body">
			<div class="row">
				<h3>Registro de Taller</h1>
			</div>
				<div class="row">
					<br>
					<form class="form-inline">
						<div class="row">
							<div class="col-md-2">
								<label>Nombres(*): </label>
							</div>
							<div class="col-md-3">
								<input class="form-control" type="text">
							</div>
							<div class="col-md-2">
								<label>Correo(*): </label>
							</div>
							<div class="col-md-3">
								<input class="form-control" type="text">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-2">
								<label>Apellidos(*): </label>
							</div>
							<div class="col-md-3">
								<input class="form-control" type="text">
							</div>
							<div class="col-md-2">
								<label>Dirección(*): </label>
							</div>
							<div class="col-md-3">
								<input type="text" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-2">
								<label>Usuario(*): </label>
							</div>
							<div class="col-md-3">
								<input class="form-control" type="text">
							</div>
							<div class="col-md-2">
								<label>Teléfono(*): </label>
							</div>
							<div class="col-md-3">
								<input class="form-control" type="text">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-2">
								<label>Contraseña(*): </label>
							</div>
							<div class="col-md-3">
								<input class="form-control" type="password">
							</div>
							<div class="col-md-2">
								<label>Nombre completo del empleado a cargo(*): </label>
							</div>
							<div class="col-md-3">
								<input class="form-control" type="text">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-2">
								<label>Confirmar Contraseña(*):</label>
							</div>
							<div class="col-md-3">
								<input class="form-control" type="password">
							</div>
							<div class="col-md-2"></div>
							<div class="col-md-3"></div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-2">
								<label>Seleccione las marcas de vehículos en que se especializa su taller(*):</label>
							</div>
							<div class="col-md-3">
								<ul class="list-group checkbox-list" >
									<a href="" class="list-group-item">
										<input type="checkbox" class=""> Chevrolet
									</a>
									<a href="" class="list-group-item">
										<input type="checkbox" class=""> Honda
									</a>
									<a href="" class="list-group-item">
										<input type="checkbox" class=""> Nissan
									</a>
									<a href="" class="list-group-item">
										<input type="checkbox" class=""> Mercedez
									</a>
								</ul>
							</div>
							<div class="col-md-2">
								<label>Seleccione los servicios que ofrece su taller(*):</label>
							</div>
							<div class="col-md-3">
								<ul class="list-group checkbox-list" >
									<a href="" class="list-group-item">
										<input type="checkbox" class=""> Pintado
									</a>
									<a href="" class="list-group-item">
										<input type="checkbox" class=""> Tapizeria
									</a>
									<a href="" class="list-group-item">
										<input type="checkbox" class=""> Eléctrico
									</a>
									<a href="" class="list-group-item">
										<input type="checkbox" class=""> Mecánico
									</a>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label>Indique la ubicación de su taller en el mapa(*): </label>
							</div>
							<div >
								<div id="map" style="min-height:300px;min-width:300px;"></div>
							</div>
						</div>
						<br>

						<div class="row">
							<div class="col-md-3">
								<a class="btn register-buttons" href="">Registrar</a>
							</div>

						</div>
					</form>
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
				background-color:#cdc0b7;

			}
			.checkbox-list
			{
				max-height: 120px;
				overflow-y:scroll;
			}
		</style>
		<script>
	      function initMap() {
	        var uluru = {lat: -25.363, lng: 131.044};
	        var map = new google.maps.Map(document.getElementById('map'), {
	          zoom: 4,
	          center: uluru,
	          disableDefaultUI: true
	        });
	        var marker = new google.maps.Marker({
	          position: uluru,
	          map: map
	        });
	      }
	      
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMWnFVjp1hJEu6zTj5Y646z15ecr1WH7Q&callback=initMap">
    </script>
@stop