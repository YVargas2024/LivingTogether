<?php
$controlador = new controladorHabitaciones();

if (isset($_GET['idhabitacion'])) {
    $row = $controlador->ver($_GET['idhabitacion']);
} else {
    header('Location: arrendatario.php');
}

if (isset($_POST['enviar'])) {
    $controlador->Eliminar($_GET['idhabitacion']);
    header('Location: arrendatario.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/Arrendatario/eliminar.css">
</head>
<body>
    <div class="custom-container">
        <div class="custom-card">
            <div class="custom-card-header">
                <h2>Habitación <?php echo $row['idhabitacion']; ?></h2>
            </div>
            <div class="custom-card-body">
                <div class="row">
                    <!-- Imagen de la habitación -->
                    <div class="col-12 mb-4">
                        <?php if (!empty($row['foto'])): ?>
                            <img src="<?php echo $row['foto']; ?>" alt="Foto de la habitación" class="custom-img-fluid" id="imgThumbnail" />
                        <?php else: ?>
                            <p>No hay foto disponible.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Lado inferior: Información -->
                    <div class="col-12">
                        <div class="custom-info-container">
                            <h3>Detalles de la Habitación</h3>
                            <p><strong>Dirección:</strong> <?php echo $row['direccion']; ?></p>
                            <p><strong>Descripción:</strong> <?php echo $row['descripcion']; ?></p>
                            <p><strong>Precio:</strong> $<?php echo number_format($row['precio'], 2); ?></p>
                            <p><strong>Fecha de Publicación:</strong> <?php echo date('d/m/Y', strtotime($row['fechapublicacion'])); ?></p>
                            <p><strong>Estado:</strong> <?php echo $row['estado']; ?></p>
                            <br>
                            <!-- Botón de Eliminar -->
                            <button class="custom-btn" onclick="openModal()">
                                <i class="fa-solid fa-trash" style="color: #f44336; font-size: 20px;"></i>
                                Eliminar Habitación
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div id="confirmModal" style="display:none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
        <div style="background-color: white; margin: 15% auto; padding: 20px; border-radius: 5px; width: 300px; text-align: center;">
            <h2>Confirmar Eliminación</h2>
            <p>¿Seguro que quieres eliminar la habitación <?php echo $row['idhabitacion']; ?> con la dirección <?php echo $row['direccion']; ?>?</p>
            <form action="" method="POST" id="deleteForm">
                <input type="submit" name="enviar" value="Eliminar" style="margin: 5px; background-color: #f44336; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">
                <button type="button" onclick="closeModal()" style="margin: 5px; padding: 10px; border: none; border-radius: 5px; background-color: #ccc; cursor: pointer;">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- JavaScript para el Modal -->
    <script>
        function openModal() {
            document.getElementById('confirmModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }
    </script>
</body>
</html>
