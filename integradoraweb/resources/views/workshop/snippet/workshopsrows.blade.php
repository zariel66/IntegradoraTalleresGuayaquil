@foreach($usuario->talleres as $t)
<tr>
	<td class="text-center col-md-3">{{$t->nombre_taller}}</td>
	<td class="text-center col-md-4">{{$t->direccion}}</td>
	<td class="text-center col-md-2">{{$t->telefono}}</td>
	<td class="text-center col-md-1">
		<a href="{{url('mostrartaller')}}/{{$t->id}}" class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
	</td>
	<td class="text-center col-md-1">
		<a href="{{url('editartaller')}}/{{$t->id}}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>
	</td>
	<td class="text-center col-md-1">
		@if(count($usuario->talleres)>1)
		<button class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$t->id}}"><span class="glyphicon glyphicon-trash"></span></button>
		@endif
	</td>

</tr>
@endforeach
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td><a href="{{url('creartaller')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Nuevo Taller</a></td>
</tr>