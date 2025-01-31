<?php
// Incluir la conexión y el modelo
require_once '../../modelo/Conexion.php';
require_once '../../modelo/Calificacion.php';

// Crear una instancia de la clase Conexion
$conexion = new Conexion();
$model = new ComentariosValoraciones($conexion->getConexion());

// Verificar si se ha recibido el id de la habitación
if (isset($_GET['idhabitacion'])) {
    $idhabitacion = $_GET['idhabitacion'];

    // Obtener los comentarios de la habitación
    $comentarios = $model->obtenerComentariosValoraciones($idhabitacion);
} else {
    echo "Error: No se ha seleccionado una habitación.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/Comentarios.css">
    <title>Comentarios - Habitación <?php echo $idhabitacion; ?></title>
</head>

<body>
    <div class="container mt-4">

        <!-- Formulario para agregar un comentario -->
        <div class="mt-4">
            <h3 class="form-title">Deja tu Comentario</h3>
            <form method="POST" action="../guardar_comentario.php" class="form-container">
                <input type="hidden" name="idhabitacion" value="<?php echo $idhabitacion; ?>" />

                <div class="left-column">
                    <div class="form-group">
                        <label for="valoracion">Valoración:</label>
                        <select name="valoracion" id="valoracion" class="form-control" required>
                            <option value="1">1 Estrella</option>
                            <option value="2">2 Estrellas</option>
                            <option value="3">3 Estrellas</option>
                            <option value="4">4 Estrellas</option>
                            <option value="5">5 Estrellas</option>
                        </select>
                        <div class="stars-container">
                            <span data-value="1" class="star">&#9733;</span>
                            <span data-value="2" class="star">&#9733;</span>
                            <span data-value="3" class="star">&#9733;</span>
                            <span data-value="4" class="star">&#9733;</span>
                            <span data-value="5" class="star">&#9733;</span>
                        </div>
                    </div>
                </div>

                <div class="right-column">
                    <div class="form-group">
                        <label for="comentario">Comentario:</label>
                        <textarea id="comentario" name="comentario" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                </div>
            </form>
        </div>





        <h1>Comentarios de la Habitación <?php echo $idhabitacion; ?></h1>

        <!-- Mostrar los comentarios -->
        <div class="comments-section mt-3">
            <?php if ($comentarios): ?>
                <?php while ($comentario = mysqli_fetch_array($comentarios)): ?>
                    <div class="comment">
                        <p><strong>Usuario <?php echo $comentario['idusuario']; ?>:</strong></p>
                        <p><?php echo $comentario['comentario']; ?></p>
                        <p><strong>Valoración:</strong> <?php echo $comentario['valoracion_id']; ?> Estrellas</p>
                        <p><small>Fecha: <?php echo $comentario['fechacomentario']; ?></small></p>
                    </div>
                    <hr>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay comentarios disponibles para esta habitación.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="../../js/Comentarios.js"></script>
</body>

</html>