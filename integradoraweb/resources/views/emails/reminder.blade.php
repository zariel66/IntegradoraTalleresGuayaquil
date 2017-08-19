<h1>Saludos {{$calificacion->user->nombre}}</h1>
<br>
<p>Hace poco visitaste <strong>{{$calificacion->taller->nombre_taller}}</strong> e hiciste uso de nuestros descuentos.</p>
<p>
	Bríndanos tu opinión de la calidad del servicio del taller a través de nuestra aplicación. Ingresa a <a href="{{url('login')}}">{{url('login')}}</a> con tu usuario  <strong>{{$calificacion->user->username}}</strong> y déjanos tus comentarios.<br>Recuerda que tu opinión es importante para nosotros y nos ayuda a mejorar la red de talleres para futuros usuarios.
</p>
<br>
<p>Te agradecemos por tu tiempo.</p>