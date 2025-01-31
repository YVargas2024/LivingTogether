<?php
if (isset($_SESSION['correo'])) {
?>

    <link rel="stylesheet" href="../../css/Componentes/Header.css">
    <div class="contr">
        <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
        </div>
        <h1 style="color: white;">Bienvenido</h1>
        <div class="user-info">
            <img src="../../../img/user.png" alt="Foto de perfil" class="profile-pic">
            <div class="user-details">
                <span class="user-name">Nombre del Usuario</span>
                <span class="user-email"><?php echo $_SESSION['correo']; ?></span>
            </div>
        </div>
    </div>
<?php
} else {
    header('Location: ../../../index.php');
}
?>