<?php
include "conexion.php";

// Verificar si se ha recibido un ID a través de la URL
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Consultar si existe el estudiante con el ID proporcionado
    $sql = $conexion->query("SELECT * FROM estudiantes WHERE id = $id");
    
    // Verificar si se obtuvo el estudiante
    if ($sql->num_rows > 0) {
        // Si se ha enviado el formulario para editar
        if (!empty($_POST["botonactualizar"])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $fecha_nacimiento = $_POST['nacimiento'];
            $correo = $_POST['correo'];

            // Realizar la actualización
            $update_sql = $conexion->query("UPDATE estudiantes SET nombre='$nombre', apellido='$apellido', fecha_nacimiento='$fecha_nacimiento', correo='$correo' WHERE id = $id");

            // Verificar si la actualización fue exitosa
            if ($update_sql) {
                echo "<script>alert('Datos actualizados correctamente.'); window.location.href='index.php';</script>";
            } else {
                echo "Error al actualizar: " . $conexion->error;
            }
        }
    } else {
        echo "Estudiante no encontrado.";
    }
} else {
    echo "ID no especificado.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Actualizar Estudiante</title>
</head>
<body>
<form class="col-4 p-3 m-auto" method="POST">
    <h3 class="text-center">Actualizar Datos</h3>
    <?php
    while ($datos = $sql->fetch_object()) { ?>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Estudiante</label>
            <input type="text" class="form-control" name="nombre" value="<?= $datos->nombre ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellidos del Estudiante</label>
            <input type="text" class="form-control" name="apellido" value="<?= $datos->apellido ?>" required>
        </div>
        <div class="mb-3">
            <label for="nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" name="nacimiento" value="<?= $datos->fecha_nacimiento ?>" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" name="correo" value="<?= $datos->correo ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="botonactualizar" value="ok">Actualizar Estudiante</button>
    <?php } ?>
</form> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
