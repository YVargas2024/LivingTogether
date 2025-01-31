<?php
include_once("./Componentes/Sidebar.php");
include_once("../../Controladores/Crud/Enrutador.php");
include_once("../../Controladores/Crud/Usuarios.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/Administrador/crud.css">
    <title>Document</title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="crud.php">Inicio</a></li>
            <li><a href="?cargar=crear">Crear</a></li>
        </ul>
    </nav>
    <section>
        <?php
        $enrutador = new Enrutador();
        $cargar = $_GET['cargar'] ?? ''; // Asigna una cadena vacía si no está definido
        if ($enrutador->validarGet($cargar)) {
            $enrutador->cargarVista($cargar);
        }
        ?>
    </section>
    </div>
</body>

</html>