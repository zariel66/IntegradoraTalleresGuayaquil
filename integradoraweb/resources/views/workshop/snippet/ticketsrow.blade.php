@foreach($rows as $row)
<tr id="fila{{$row->id}}">
	<td class="col-md-1 text-center">{{$row->desc_code}}</td>
	<td class="col-md-2 text-center">{{$row->nombre}} {{$row->apellido}}</td>
	<td class="col-md-3 text-center">{{$row->nombre_taller}}</td>
	<td class="col-md-2 text-center">
		<input type="text" class="form-control" placeholder="$">
	</td>

	<td class="col-md-1 text-center">
		<input id="preciooriginal{{$row->id}}" type="text" class="form-control" style="width:75%;float:left;" placeholder="%"><!-- <span class="porcentaje-label">%</span> -->
	</td>
	<td class="col-md-2">
		<input id="descuento{{$row->id}}" type="text" class="form-control">
	</td>
	<td class="col-md-1  text-center">
		<input id="total{{$row->id}}" type="submit" value="Enviar" class="form-control">
	</td>
</tr>
@endforeach