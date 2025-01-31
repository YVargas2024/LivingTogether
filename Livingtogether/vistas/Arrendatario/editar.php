<?php
require_once '../../Controladores/Crud_hab/Controlador.php';

$controlador = new controladorHabitaciones();

// Verificar si se proporcionó un ID de habitación
if (isset($_GET['idhabitacion'])) {
    $row = $controlador->ver($_GET['idhabitacion']);
    $opcionesDisponibilidad = $controlador->listarDisponibilidad();
} else {
    header('Location: arrendatario.php');
    exit;
}

// Procesar la edición si se envía el formulario
if (isset($_POST['enviar'])) {
    $fotoRuta = null;
    // Verificar si se subió una nueva foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $fotoNombre = basename($_FILES['foto']['name']);
        $fotoRuta = "../../img/img_inmuebles/" . $fotoNombre;
        move_uploaded_file($_FILES['foto']['tmp_name'], $fotoRuta);
    }

    // Llamar al controlador para editar la habitación
    $controlador->editar(
        $_GET['idhabitacion'],
        $_POST['direccion'],
        $_POST['descripcion'],
        $_POST['precio'],
        $_POST['fechapublicacion'],
        $_POST['disponibilidad_id'],
        $fotoRuta // Pasar la ruta de la nueva foto si existe
    );

    header('Location: arrendatario.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/Arrendatario/editar.css">
</head>

<body>
    <div class="form-container">
        <h2>Editar Habitación</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID Habitación:</label>
                <input type="text" name="idhabitacion" class="form-control" value="<?php echo $row['idhabitacion']; ?>" disabled>
            </div>
            <div class="form-group">
                <label>ID Usuario:</label>
                <input type="text" name="idusuario" class="form-control" value="<?php echo $row['idusuario']; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Dirección:</label>
                <input type="text" name="direccion" class="form-control" value="<?php echo $row['direccion']; ?>" required>
            </div>
            <div class="form-group">
                <label>Descripción:</label>
                <input type="text" name="descripcion" class="form-control" value="<?php echo $row['descripcion']; ?>" required>
            </div>
            <div class="form-group">
                <label>Precio:</label>
                <input type="number" name="precio" class="form-control" value="<?php echo $row['precio']; ?>" required>
            </div>
            <div class="form-group">
                <label>Fecha Publicación:</label>
                <input type="datetime-local" name="fechapublicacion" class="form-control" value="<?php echo $row['fechapublicacion']; ?>" required>
            </div>
            <div class="form-group">
                <label>Estado (Disponibilidad):</label>
                <select name="disponibilidad_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($opcionesDisponibilidad as $opcion): ?>
                        <option value="<?php echo $opcion['iddisponibilidad']; ?>"
                            <?php echo $row['disponibilidad_id'] == $opcion['iddisponibilidad'] ? 'selected' : ''; ?>>
                            <?php echo $opcion['estado']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Foto (opcional):</label>
                <input type="file" name="foto" class="form-control-file">
                <?php if (!empty($row['foto'])): ?>
                    <p>Foto actual:</p>
                    <img src="<?php echo $row['foto']; ?>" alt="Foto actual" class="img-thumbnail" width="200">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <button type="submit" name="enviar" class="btn-submit">Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>

</html>