<?php

session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 3) {
    header('Location: ../vistas/inicioRegistro.php');
    exit();
}
// Cerrar sesión
if (isset($_POST['cerrarSesion'])) {
    session_unset(); // Limpiar todas las variables de sesión
    session_destroy(); // Destruir la sesión
    header('Location: ../index.php'); // Redirigir al inicio
    exit();
}
?>
<?php
if (isset($_SESSION['usuario'])) {
?>

    <div class="container">
        <h1>Hola, bienvenido <?php echo '<strong>' . $_SESSION['usuario'] . '</strong>'; ?></h1>
        <div>
            <form action="" method="post">
                <button class="btn" name="cerrarSesion">Cerrar Sesion</button>
            </form>
        </div>
    </div>

<?php
} else {
    header('Location: ../index.php');
}
?>