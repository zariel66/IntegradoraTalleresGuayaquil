@foreach($usuario->talleres as $t)
<div id="myModal{{$t->id}}" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Confirmar Acción</h4>
	      </div>
	      <div class="modal-body">
	        <p>¿Esta seguro que desea eliminar el taller?. Toda la información relacionada será eliminada del sistema</p>
	      </div>
	      <div class="modal-footer">
	      	<a href="{{url('eliminartaller')}}/{{$t->id}}" class="btn btn-danger">Eliminar</a>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	      </div>
	    </div>

	  </div>
	</div>
@endforeach