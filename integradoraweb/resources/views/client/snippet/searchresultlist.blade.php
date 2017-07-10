@foreach($results as $fila)
<a href="{{url('perfiltaller')}}/{{$fila->id}}" class="list-group-item align-items-start">
	<div class="justify-content-between">
		<h4 class="mb-1" >{{$fila->nombre_taller}}</h4>
		
		<small>{{$fila->direccion}}</small>
		<div><strong>A {{number_format($fila->distance, 2, '.', ',')}} Km de distancia</strong></div>
	</div>

</a>
@endforeach