<?php
if (!empty($_POST["botoncrear"])) {
  
    if (!empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["nacimiento"]) && !empty($_POST["correo"])) {
        
        
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['nacimiento'];
        $correo = $_POST['correo'];

      
        $sql = $conexion->query("INSERT INTO estudiantes (nombre, apellido, fecha_nacimiento, correo) 
         VALUES ('$nombre', '$apellido', '$fecha_nacimiento', '$correo')");


        if ($sql) {
            header(  "Location: index.php"); 
            exit; // Terminar el script después de redirigir
        } else {
            echo "Error al registrar: " . $conexion->error; 
        }
    } else {
        echo "Hay campos vacíos o incompletos.";
    }
}
?>

