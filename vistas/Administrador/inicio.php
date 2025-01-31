<?php
// Asegúrate de que la ruta sea correcta
include_once("../../Controladores/Crud/Usuarios.php");

$controlador = new controladorUsuarios();
$resultado = $controlador->index();
?>
<link rel="stylesheet" href="../../css/Administrador/crud.css">
<h3>Crud usuarios</h3>
<table>
    <thead>
        <th>Id</th>
        <th>Nombre de Usuario</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_array($resultado)): ?>
            <tr>
                <td><?php echo $row['idusuario']; ?></td>
                <td><?php echo $row['nombreusuario']; ?></td>
                <td><?php echo $row['correo']; ?></td>
                <td><?php echo $row['nombre_rol']; ?></td>
                <td>
                    <a href="?cargar=ver&idusuario=<?php echo $row['idusuario']; ?>">Ver</a>
                    <a href="?cargar=editar&idusuario=<?php echo $row['idusuario']; ?>">Editar</a>
                    <a href="?cargar=eliminar&idusuario=<?php echo $row['idusuario']; ?>">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>