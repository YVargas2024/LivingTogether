<?php
$controlador = new controladorHabitaciones();

if (isset($_POST['enviar'])) {
    $r = $controlador->crear($_POST['direccion'], $_POST['descripcion'], $_POST['precio'], $_POST['fechapublicacion'], $_POST['disponibilidad_id']);

    if ($r) {
        echo "Se ha registrado correctamente tu nueva habitacion";
        header('Location: arrendatario.php');
    } else {
        echo  "Se ha registrado correctamente tu nueva habitacion";
        header('Location: arrendatario.php');
    }
}
?>

<link rel="stylesheet" href="../../css/Arrendatario/crear.css">

<div class="form-container">
    <h3>Registra una Nueva habitación</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="direccion" required>
        </div>
        <div class="form-group">
            <label>Descripción</label>
            <input type="text" name="descripcion" required>
        </div>
        <div class="form-group">
            <label>Precio</label>
            <input type="number" name="precio" min="100000" max="10000000" required>
        </div>
        <div class="form-group">
            <label>Fecha Publicación</label>
            <input type="datetime-local" name="fechapublicacion" required>
        </div>
        <div class="form-group">
            <label>Estado</label>
            <select name="disponibilidad_id" required>
                <option value="1">Disponible</option>
                <option value="2">No Disponible</option>
            </select>
        </div>
        <div class="form-group">
            <label>Foto</label>
            <input type="file" name="foto" accept="image/*" required>
        </div>
        <div class="form-group">
            <input type="submit" name="enviar" value="Crear" class="btn-submit">
        </div>
    </form>
</div>