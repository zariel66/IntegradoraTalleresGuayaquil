@foreach($rows as $row)
<tr id="fila{{$row->id}}">
	<td class="col-md-1 text-center"><span class="label label-default" style="font-size: 90%;">{{$row->desc_code}}</span></td>
	<td class="col-md-2 text-center">{{$row->nombre}} {{$row->apellido}}</td>
	<td class="col-md-3 text-center">{{$row->nombre_taller}}</td>
	<td class="col-md-2 text-center">
		<input id="preciooriginal{{$row->id}}" type="text" class="form-control doubleonly" placeholder="$" maxlength="7" oninput="calcTotal({{$row->id}})" onkeypress="doubleOnlyPress(event)" onkeyup="doubleOnlyUp(event)">
	</td>

	<td class="col-md-1 text-center">
		<input id="descuento{{$row->id}}" type="text" class="form-control" style="width:75%;float:left;" placeholder="%" maxlength="3" onkeypress="return isNumber(event)" oninput="maxnumber(event,100);calcTotal({{$row->id}})"><!-- <span class="porcentaje-label">%</span> -->
	</td>
	<td class="col-md-2">
		<input id="total{{$row->id}}" type="text" class="form-control" placeholder="$" readonly>
	</td>
	<td class="col-md-1  text-center">
		<input id="btnEnviar{{$row->id}}" type="submit" value="Enviar" class="form-control sendDiscount" onclick="actualizarRecomendacion({{$row->id}})" disabled>
		
	</td>
</tr>
@endforeach