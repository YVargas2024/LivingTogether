<?php
// Iniciar sesión para obtener el idusuario
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idusuario'])) {
    echo "Por favor, inicia sesión para dejar un comentario.";
    exit;
}

// Procesar el comentario enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['idhabitacion'], $_POST['comentario'], $_POST['valoracion'])) {
        $idhabitacion = $_POST['idhabitacion'];
        $comentario = $_POST['comentario'];
        $valoracion = $_POST['valoracion'];
        $idusuario = $_SESSION['idusuario'];

        // Incluir el controlador
        require_once '../Controladores/CalificacionController.php';
        $controller = new ComentariosValoracionesController();

        // Guardar el comentario
        $controller->guardarComentario($idhabitacion, $idusuario, $comentario, $valoracion);
    } else {
        echo "Por favor, completa todos los campos.";
    }
}
