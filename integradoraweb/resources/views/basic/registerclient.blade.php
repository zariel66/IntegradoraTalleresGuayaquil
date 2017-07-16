@extends("template")
@section("content")
<div id="form-section-background" class="container">
	<div class="panel col-md-10 col-md-offset-1">
		<div class="panel-body">
			
			<div class="row">
				<h3>Registro de Usuario</h1>
			</div>
			<div class="row">
				<br>
				<form class="form-inline"  action="registroclientesubmit" method="GET" autocomplete="on">
					
					<div class="row">
						<div class="col-md-2">
							<label>Nombres(*): </label>
						</div>
						<div class="col-md-3">
							<input value="{{old('nombre')}}" class="form-control" name="nombre" type="text"
							@if($errors->has('nombre'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('nombre') }}</small></div>
						</div>
						<div class="col-md-2">
							<label>Correo(*): </label>
						</div>
						<div class="col-md-3">
							<input value="{{old('correo')}}" class="form-control" name="correo" type="text"
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
							<input value="{{old('apellido')}}" class="form-control" name="apellido" type="text"
							@if($errors->has('apellido'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('apellido') }}</small></div>
						</div>
						<div class="col-md-2">
							<label>Marca del Vehículo(*): </label>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="marca">
								@foreach($marcas as $marca)
								<option value="{{$marca->id}}">{{$marca->nombre}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-2">
							<label>Usuario(*): </label>
						</div>
						<div class="col-md-3">
							<input value="{{old('username')}}" class="form-control" name="username" type="text"
							@if($errors->has('username'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('username') }}</small></div>
						</div>
						<div class="col-md-2">
							<label>Modelo del vehículo(*): </label>
						</div>
						<div class="col-md-3">
							<input value="{{old('modelo')}}" class="form-control" name="modelo" type="text"
							@if($errors->has('modelo'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('modelo') }}</small></div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-2">
							<label>Contraseña(*): </label>
						</div>
						<div class="col-md-3">
							<input value="{{old('password')}}" class="form-control" type="password" name="password"
							@if($errors->has('password'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('password') }}</small></div>
						</div>
						<div class="col-md-2"></div>
						<div class="col-md-3"></div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-2">
							<label>Confirmar Contraseña(*):</label>
						</div>
						<div class="col-md-3">
							<input class="form-control" type="password" name="password_confirmation"
							@if($errors->has('password_confirmation'))
							style="border-color:red;"
							@endif
							>
							<div style="color:red"><small>{{ $errors->first('password_confirmation') }}</small></div>
						</div>
						<div class="col-md-2"></div>
						<div class="col-md-3"></div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-3">
							<input class="btn register-buttons" type="submit" value="Registrar">
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
		height: 700px;
		background-image: url("{{ URL::asset('imagenes/icons/bgtool.jpg')}}");
		background-size: 300px 300px;
		padding: 5%;

	}
	#form-section-background .panel{
		border-radius: 25px;
		padding-left: 80px;
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

	</style>
@stop	