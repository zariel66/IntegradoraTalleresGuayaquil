@foreach($usuario->vehiculos as $v)
<tr>
	<td class="text-center">{{$v->modelo}}</td>
	<td class="text-center">{{$v->marca->nombre}}</td>
	<td class="text-center">
		@if(count($usuario->vehiculos)>1)
		<button onclick="deleteCar({{$v->id}})" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
		@endif
	</td>

</tr>
@endforeach
<tr>
	<td class="text-center"><input id="modelo" name="text" type="text" class="form-control" placeholder="Ingrese el modelo de su vehículo"></td>
	<td class="text-center">
		<select id="marca" name="idmarca" class="form-control">
			@foreach($marcas as $m)
			<option value="{{$m->id}}">{{$m->nombre}}</option>
			@endforeach
		</select>
	</td>
	<td class="text-center">
		<button onclick="addCar()" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Añadir Vehículo</button>
	</td>

</tr>