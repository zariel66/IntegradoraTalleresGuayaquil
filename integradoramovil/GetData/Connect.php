<?php
 $servidor="localhost";
 $user="root";
 $pass="1234";
 $db_name="db_integradora";

 $conexion = mysqli_connect($servidor,$user,$pass,$db_name);

 if(mysqli_connect_errno($conexion)) {
   echo "la base datos no ha podido conectarse".mysqli_connect_errno();
 }
 else{
 	 echo "la conexion es satifactoria";
 }
 
 /*sifon para la plato-----caucho reductos de 2 1/2 a 1 1/4 a la pared.    */
 ?>

