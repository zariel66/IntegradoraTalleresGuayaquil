<form>
	<div class="form-group">
		<label for="username">Usuario:</label>
		<input maxlength="32" type="text" class="form-control" name="username" value="{{ $usuario->username}}"
		@if($errors->has('username'))
		style="border-color:red;"
		@endif
		>
		<div style="color:red"><small>{{ $errors->first('username') }}</small></div>
	</div>
	<div class="form-group">
		<label for="">Nombres:</label>
		<input maxlength="100" type="text" class="form-control" name="nombre" value="{{$usuario->nombre}}"
		@if($errors->has('nombre'))
		style="border-color:red;"
		@endif
		>
		<div style="color:red"><small>{{ $errors->first('nombre') }}</small></div>
	</div>
	<div class="form-group">
		<label for="">Apellidos:</label>
		<input maxlength="100" type="text" class="form-control" name="apellido"  value="{{$usuario->apellido}}"
		@if($errors->has('apellido'))
		style="border-color:red;"
		@endif
		>
		<div style="color:red"><small>{{ $errors->first('apellido') }}</small></div>
	</div>
  	<div class="form-group">
		<label for="">Correo:</label>
		<input maxlength="100" type="text" class="form-control" name="correo"  value="{{$usuario->correo}}"
		@if($errors->has('correo'))
		style="border-color:red;"
		@endif
		>
		<div style="color:red"><small>{{ $errors->first('correo') }}</small></div>
	</div>
</form>