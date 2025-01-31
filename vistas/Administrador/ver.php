<?php
$controlador = new controladorUsuarios();
if (isset($_GET['idusuario'])) {
    $row = $controlador->ver($_GET['idusuario']);
} else {
    header('Location: crud.php');
}
?>
<style>
    /* Estilo para el bloque de información */
    .info-block {
        background-color: var(--white);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 20px auto;
        /* Centrando el bloque */
        font-family: "Viga", sans-serif;
        color: var(--black1);
    }

    .info-block h2 {
        color: var(--blue);
        text-align: center;
        margin: 40px 0 20px;
        /* Ajuste de margen para bajar el título */
    }

    .info-block b {
        color: var(--blue);
        /* Color del texto en negrita */
        font-size: 1.1rem;
        margin-bottom: 5px;
        display: inline-block;
    }

    .info-block p {
        font-size: 1rem;
        color: var(--black2);
        margin-bottom: 15px;
        padding-left: 10px;
    }

    .info-block hr {
        border: none;
        height: 2px;
        background-color: var(--blue);
        margin: 15px 0;
    }
</style>
<div class="info-block">
    <h2>Información usuario</h2>
    <b>Nombres:</b>
    <p><?php echo $row['nombreusuario']; ?></p>

    <hr>

    <b>Apellidos:</b>
    <p><?php echo $row['correo']; ?></p>

    <hr>

    <b>Rol:</b>
    <p><?php echo $row['idrol']; ?></p>
</div>