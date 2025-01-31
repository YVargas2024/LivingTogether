<?php
$controlador = new controladorUsuarios();
if (isset($_GET['idusuario'])) {
    $row = $controlador->ver($_GET['idusuario']);
} else {
    header('Location: crud.php');
}
if (isset($_POST['enviar'])) {
    $controlador->Eliminar($_GET['idusuario']);
    header('Location: crud.php');
}
?>
¿Usted de verdad quiere eliminar al usuario <?php echo $row['nombreusuario']; ?>?
<br><br>
<form action="" method="post">
    <input type="submit" name="enviar" value="Eliminar">
</form>