@foreach($usuario->vehiculos as $v)
<tr id="v{{$v->id}}">
	<td class="text-center">{{$v->modelo}}</td>
	<td class="text-center">{{$v->marca->nombre}}</td>
	<td class="text-center">
		<!-- <a href="{{url('editarvehiculo')}}/{{$v->id}}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a> -->
		<button onclick="$('#ve{{$v->id}}').show();$('#v{{$v->id}}').hide();" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></button>
	</td>
	<td class="text-center">
		@if(count($usuario->vehiculos)>1)
		<button onclick="deleteCar({{$v->id}})" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
		@endif
	</td>

</tr>
<tr id="ve{{$v->id}}" style="display:none;">
	<td class="text-center"><input value="{{$v->modelo}}" id="modelo{{$v->id}}" name="text" type="text" class="form-control" placeholder="Ingrese el modelo de su vehículo"></td>
	<td class="text-center">
		<select id="marca{{$v->id}}" class="form-control">
			@foreach($marcas as $m)
			@if($m->id == $v->marca->id)
			<option selected value="{{$m->id}}">{{$m->nombre}}</option>
			@else
			<option value="{{$m->id}}">{{$m->nombre}}</option>
			@endif
			@endforeach
		</select>
	</td>
	<td></td>
	<td class="text-center">
		<button onclick="editCar({{$v->id}})" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
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
	<td></td>
	<td class="text-center">
		<button onclick="addCar()" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Añadir Vehículo</button>
	</td>

</tr>