<?php
include "conexion.php";

if (!empty($_GET["id"])){
    $id = $_GET["id"];
    $eliminar =$conexion->query("DELETE FROM estudiantes WHERE id = $id");

    if ($eliminar ==1){
        echo"borrado exitoso";
    
    
}
}
?>
