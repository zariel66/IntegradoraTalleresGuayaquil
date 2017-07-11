<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
 $nombre=$_POST['nombre'];
 $apellido=$_POST['apellido'];
 $username=$_POST['username'];
 $password=$_POST['password'];
 $correo=$_POST['correo'];
 $hash =hashFunction($password);
 $encrypted_password = $hash["encrypted"];
 $salt = $hash["salt"];
 include('Connect.php');
 $sql="INSERT INTO usuario (nombre,apellido,tipo,username,password,correo,remember_token) VALUES('$nombre','$apellido','2','$username','$encrypted_password','$correo','$salt')";
 if (mysqli_query($conexion,$sql)){
    echo "exito";
 }else{echo "no registro";
}

}
else{echo 'error';

}

function hashFunction($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
?>