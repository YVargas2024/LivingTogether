<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap -->
    <link rel="stylesheet" href="../../css/Arrendatario/inicio.css">
</head>

<body>
    <?php
    include_once("../../Controladores/Crud_hab/Controlador.php");
    $controlador = new controladorHabitaciones();
    $resultado = $controlador->index();

    if (is_array($resultado) && empty($resultado)) {
        echo "<p>No hay habitaciones disponibles.</p>";
    } else {
    ?>
        <div class="container" style="margin-top:30px;">
            <div class="row">
                <?php while ($row = mysqli_fetch_array($resultado)): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h2>Habitación <?php echo $row['idhabitacion']; ?></h2>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($row['foto'])): ?>
                                    <img src="<?php echo $row['foto']; ?>" alt="Foto de la habitación" />
                                <?php else: ?>
                                    <p>No hay foto disponible.</p>
                                <?php endif; ?>

                                <p><strong>Precio:</strong> <?php echo $row['precio']; ?></p>
                                <p><strong>Descripción:</strong> <?php echo $row['descripcion']; ?></p>
                                <p><strong>Fecha Publicación:</strong> <?php echo $row['fechapublicacion']; ?></p>
                                <p><strong>Dirección:</strong> <?php echo $row['direccion']; ?></p>
                                <p><strong>Estado:</strong> <?php echo $row['estado']; ?></p>
                            </div>
                            <div class="card-footer">
                                <a href="?cargar=ver&idhabitacion=<?php echo $row['idhabitacion']; ?>" class="btn btn-primary">Ver</a>
                                <a href="?cargar=editar&idhabitacion=<?php echo $row['idhabitacion']; ?>" class="btn btn-warning">Editar</a>
                                <a href="?cargar=eliminar&idhabitacion=<?php echo $row['idhabitacion']; ?>" class="btn btn-danger">Eliminar</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php
    }
    ?>
</body>

</html>