<?php
require_once '../../modelo/Conexion.php'; // Asegúrate de que la ruta sea correcta

// Crear una nueva conexión
$conexion = new Conexion();
$conn = $conexion->getConexion();

// Obtener el ID del perfil de la URL
$idPerfil = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Consultar la información del perfil
$perfilQuery = "
    SELECT p.*, fp.fotop
    FROM perfiles p
    LEFT JOIN fotos_perfil fp ON p.idperfil = fp.idperfil
    WHERE p.idperfil = $idPerfil
";
$perfilResult = mysqli_query($conn, $perfilQuery);

if (mysqli_num_rows($perfilResult) > 0) {
    $perfil = mysqli_fetch_assoc($perfilResult);
} else {
    echo "Perfil no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil de <?= $perfil['nombre'] ?></title>
    
    <link rel="stylesheet" href="../../css/Roomies/perfil.css">

</head>

<body>
    <div class="perfil-container">
        <img src="data:image/jpeg;base64,<?= base64_encode($perfil['fotop']) ?>" alt="Perfil de <?= $perfil['nombre'] ?>">
        <div class="info">
            <h2><?= $perfil['nombre'] ?> <?= $perfil['segundo_nombre'] ?> <?= $perfil['apellidos'] ?></h2>
            <p><strong>Edad:</strong> <?= $perfil['edad'] ?> años</p>
            <p><strong>Rol:</strong> <?= $perfil['profesion'] ?></p>
            <p><strong>Descripción:</strong> <?= $perfil['descripcion'] ?></p>
        </div>
        <a href="./perfiles.php" class="btn-regresar">Regresar a Perfiles</a>
    </div>
</body>

</html>

<?php
// Cerrar la conexión
$conexion->cerrarConexion();
?>