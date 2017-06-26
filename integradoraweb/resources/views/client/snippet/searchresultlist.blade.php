@foreach($results as $fila)
<a href="#" class="list-group-item align-items-start">
	<div class="justify-content-between">
		<h4 class="mb-1" >{{$fila->nombre_taller}}</h4>
		
		<small>{{$fila->direccion}}</small>
		<div><small>A {{number_format($fila->distance, 2, '.', ',')}} Km de distancia</small></div>
	</div>

</a>
@endforeach