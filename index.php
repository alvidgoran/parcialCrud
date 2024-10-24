<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"> 
    <title>ACTIVIDAD DE CRUD</title>
    <style>
        /* Para pantallas con un ancho mínimo de 768 píxeles */
        @media (min-width: 768px) {
            .form-container, .table-container {
                flex: 0 0 48%;
                max-width: 48%;
            }

            .spacer {
                flex: 0 0 4%;
                max-width: 4%;
            }
        }

        /* Para pantallas con un ancho máximo de 767 píxeles */
        @media (max-width: 767px) {
            .table-container {
                margin-top: 20px;
            }
        }

        /* Nueva regla para la tabla */
        .table-container {
            height: auto; /* Cambia a auto para que ajuste su altura automáticamente */
        }

        /* Eliminar el overflow */
        .table-responsive {
            overflow: visible; /* Asegúrate de que no haya scroll */
        }
    </style>
</head>
<script>
    function eliminar() {
        var respuesta = confirm("¿DESEA CONFIRMAR EL BORRADO?");
        return respuesta;
    }
</script>
<body>
    <div class="container mt-5">
        <div class="d-flex flex-wrap justify-content-between">
            <div class="form-container">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>BIENVENIDO AL REGISTRO</h3>
                    </div>
                    <div class="card-body">
                        <form  method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Estudiante</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellidos del Estudiante</label>
                                <input type="text" class="form-control" name="apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="nacimiento" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" name="correo" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="botoncrear" value="ok">Registrar Estudiante</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="spacer"></div>

            <div class="table-container">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Datos  Registrados</h3>
                    </div>
                    <div class="card-body col-6">
                        <div class="table-responsive col-4">
                            <table class="table">
                                <thead class="bg-danger text-white">
                                    <tr>  
                                        <th scope="col">ID</th>
                                        <th scope="col">NOMBRE</th>
                                        <th scope="col">APELLIDO</th>
                                        <th scope="col">FECHA DE NACIMIENTO</th>
                                        <th scope="col">CORREO</th>
                                        <th scope="col">BOTONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        include "conexion.php";
                                        include "registros.php";
                                        include "eliminar_estudiante.php";

                                        // Número de registros por página
                                        $registrosPorPagina = 15;

                                        // Obtener el número total de registros
                                        $resultadoTotal = $conexion->query("SELECT COUNT(*) AS total FROM estudiantes");
                                        $totalRegistros = $resultadoTotal->fetch_object()->total;

                                        // Calcular el número total de páginas
                                        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

                                        // Obtener el número de página actual
                                        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

                                        // Calcular el registro inicial
                                        $offset = ($paginaActual - 1) * $registrosPorPagina;

                                        // Consulta para obtener los registros de la página actual
                                        $sql = $conexion->query("SELECT * FROM estudiantes LIMIT $offset, $registrosPorPagina");

                                        if ($sql->num_rows > 0) {
                                            while ($datos = $sql->fetch_object()) { ?>
                                                <tr>
                                                    <td><?= $datos->id ?></td>
                                                    <td><?= $datos->nombre ?></td>
                                                    <td><?= $datos->apellido ?></td>
                                                    <td><?= $datos->fecha_nacimiento ?></td>
                                                    <td><?= $datos->correo ?></td>
                                                    <td>
                                                        <a href="editar.php?id=<?= $datos->id ?>" class="btn btn-sm btn-warning">EDITAR</a>
                                                        <a onclick="return eliminar()" href="index.php?id=<?= $datos->id ?>" class="btn btn-sm btn-danger">ELIMINAR</a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>No hay estudiantes registrados.</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php 
                                for ($i = 1; $i <= $totalPaginas; $i++) {
                                    echo "<li class='page-item " . ($i == $paginaActual ? 'active' : '') . "'>
                                            <a class='page-link' href='index.php?pagina=$i'>$i</a>
                                          </li>";
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
