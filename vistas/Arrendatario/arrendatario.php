<?php
include_once("../../Controladores/Crud_hab/Enrutador.php");
include_once("../../Controladores/Crud_hab/Controlador.php");
include_once("./Componentes/Header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/Arrendatario/arrendatario.css">
    <title>Bienvenido Arrendatario</title>
</head>

<body>
    <section>
        <h1>Tus Habitaciones</h1>
        <nav>
            <ul>
                <li><a href="?cargar=crear" id="registro-btn">Registrar</a></li>
                <li><a href="?cargar=inicio" id="volver-btn">Volver</a></li>
            </ul>
        </nav>
        <?php
        $enrutador = new Enrutador();
        $cargar = $_GET['cargar'] ?? ''; // Asigna una cadena vacía si no está definido
        if ($enrutador->validarGet($cargar)) {
            $enrutador->cargarVista($cargar);
        }
        ?>
    </section>
</body>
<footer>
    <div id="help-button" onmouseover="showGreeting()" onmouseout="hideGreeting()">
        <a href="https://wa.me/1234567890?text=¡Hola!%20Necesito%20ayuda%20con%20LivingTogether." target="_blank" class="whatsapp-link">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp Logo" class="whatsapp-logo">
        </a>
        <div id="greeting-message">¿En qué te puedo ayudar?</div>
    </div>
    <script src="../../js/arrendatario.js"></script>
</footer>
</html>