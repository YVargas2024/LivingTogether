<?php
// Ajusta la ruta del archivo de conexión según la estructura de carpetas
include_once('../../modelo/Conexion.php');

// Crear conexión
$conexion = new Conexion();
$conn = $conexion->getConexion();

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL - Limitar a 6 perfiles
$sql = "SELECT p.*, COALESCE(MAX(f.fotop), '') AS fotop 
        FROM perfiles p 
        LEFT JOIN fotos_perfil f ON p.idperfil = f.idperfil
        WHERE p.visibilidad = 'pública'
        GROUP BY p.idperfil
        LIMIT 6";  // Aquí se agrega el límite a 6

$result = $conexion->consultaRetorno($sql);

// Verificar resultado de la consulta
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Construir array de perfiles
$profiles = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['fotop'] = $row['fotop'] ? base64_encode($row['fotop']) : null;
    $profiles[] = $row;
}

// Devolver JSON
echo json_encode($profiles);

// Cerrar conexión
$conexion->cerrarConexion();
