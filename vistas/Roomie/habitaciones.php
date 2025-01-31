<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/Arrendatario/habitaciones.css">
</head>

<body>
    <title>Habitaciones</title>
    <?php

    include_once("../../Controladores/Crud_hab/Controlador.php");
    $controlador = new controladorHabitaciones();
    $habitaciones = $controlador->listarTodasLasHabitaciones();
    ?>
    <br>
    <br>
    <div class="container mt-4">
        <?php
        include_once("./Componentes/Header.php"); ?>
        <br>
        <br>
        <br>
        <h1>Habitaciones</h1>

        <div class="row">
            <?php if ($habitaciones): ?>
                <?php while ($row = mysqli_fetch_array($habitaciones)): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header text-center">
                                <h5>Habitación <?php echo $row['idhabitacion']; ?></h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($row['foto'])): ?>
                                    <img src="<?php echo $row['foto']; ?>" alt="Foto de la habitación" class="img-fluid mb-3" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <p>No hay foto disponible.</p>
                                <?php endif; ?>

                                <p><strong>Precio:</strong> $<?php echo number_format($row['precio'], 2); ?></p>
                                <p><strong>Descripción:</strong> <?php echo $row['descripcion']; ?></p>
                                <p><strong>Dirección:</strong> <?php echo $row['direccion']; ?></p>
                                <p><strong>Estado:</strong> <?php echo $row['estado']; ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <a href="ver.php?idhabitacion=<?php echo $row['idhabitacion']; ?>" class="btn btn-primary">Ver</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No hay habitaciones disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
    

</body>

</html>