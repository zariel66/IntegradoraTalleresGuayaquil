@foreach($registros as $r)
<tr>
<td class="text-center">{{$r->nombre}} {{$r->apellido}}</td>
<td class="text-center">{{ \Carbon\Carbon::parse($r->fecha_visita)->format('d/m/Y')}}</td>
<td class="text-center">{{$r->nombre_taller}}</td>
<td class="text-center">{{$r->descuento}}%</td>
<td class="text-center">${{$r->total}}</td>
</tr>
@endforeach