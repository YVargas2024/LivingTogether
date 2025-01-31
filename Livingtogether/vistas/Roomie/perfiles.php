<?php
require_once("../../modelo/Conexion.php"); // Asegúrate de que la ruta sea correcta

// Crear una nueva conexión
$conexion = new Conexion();
$conn = $conexion->getConexion();

// Obtener el número total de perfiles únicos
$totalPerfilesQuery = "
    SELECT COUNT(DISTINCT p.idperfil) FROM perfiles p
";
$totalPerfilesResult = mysqli_query($conn, $totalPerfilesQuery);
$totalPerfiles = mysqli_fetch_array($totalPerfilesResult)[0];
$perPage = 9; // Número de perfiles por página
$totalPages = ceil($totalPerfiles / $perPage);

// Obtener la página actual
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages)); // Asegurarse de que la página sea válida
$offset = ($page - 1) * $perPage;

// Consultar perfiles únicos para la página actual
$perfilesQuery = "
    SELECT p.*, fp.fotop
    FROM perfiles p
    LEFT JOIN fotos_perfil fp ON p.idperfil = fp.idperfil
    GROUP BY p.idperfil
    LIMIT $offset, $perPage
";
$perfilesResult = mysqli_query($conn, $perfilesQuery);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfiles</title>
    <link rel="stylesheet" href="../../css/Roomies/perfiles2.css">
</head>

<body>
    <?php include_once("./Componentes/Header.php"); ?><br><br><br><br><br>
    <section class="perfil-container">
        <div class="perfil-grid">
            <?php while ($perfil = mysqli_fetch_assoc($perfilesResult)): 
                $rol = $perfil['profesion'] ? $perfil['profesion'] : 'Sin rol definido'; // Mostrar rol
            ?>
                <div class="perfil-card" style="--rand: <?= rand(0, 100) ?>;">
                    <img src="data:image/jpeg;base64,<?= base64_encode($perfil['fotop']) ?>" alt="Perfil de <?= $perfil['nombre'] ?>">
                    <div class="perfil-rol"><?= $rol ?></div>
                    <h2 class="perfil-nombre"><?= $perfil['nombre'] ?> <?= $perfil['segundo_nombre'] ?> <?= $perfil['apellidos'] ?></h2>
                    <span class="perfil-edad"><?= $perfil['edad'] ?> años</span>
                    <a href="perfil.php?id=<?= $perfil['idperfil'] ?>" class="perfil-ver">Ver perfil</a>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Paginación -->
        <div class="paginacion">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </section>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->cerrarConexion();
?>
