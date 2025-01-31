<?php
session_start();
include_once("../../../Controladores/ControladorPerfil.php");
$controlador = new ControladorPerfil();

// Listar perfiles
$profiles = $controlador->index($_SESSION['idusuario']); // Supone que `idusuario` está en la sesión

// Lógica para manejar el formulario de creación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'crear') {
    $data = $_POST;
    $data['idusuario'] = $_SESSION['idusuario'];
    $controlador->crear($data);
    header("Location: index.php"); // Recargar para actualizar la lista
    exit();
}

// Lógica para manejar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'editar') {
    $data = $_POST;
    $foto = $_FILES['foto'] ?? null; // Obtener la foto si está disponible
    $controlador->editar($_POST['idperfil'], $data, $foto);
    header("Location: index.php"); // Recargar para actualizar la lista
    exit();
}

// Lógica para manejar la eliminación
if (isset($_GET['action']) && $_GET['action'] == 'eliminar' && isset($_GET['id'])) {
    $controlador->eliminar($_GET['id']);
    header("Location: index.php"); // Recargar para actualizar la lista
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'eliminarFoto' && isset($_GET['id'])) {
    $controlador->eliminarFoto($_GET['id']);
    header("Location: index.php"); // Recargar para actualizar la lista
    exit();
}



// Obtener perfil para edición (si está seleccionado)
$profileToEdit = null;
if (isset($_GET['action']) && $_GET['action'] == 'editar' && isset($_GET['id'])) {
    $profileToEdit = $controlador->ver($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Perfiles</title>
    <link rel="stylesheet" href="../../../css/Roomies/editarperfil.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>

    <h1>Editar Perfil</h1>
    <a href="../roomie.php">Inicio</a>
    <!-- Sección para listar perfiles -->
    <h2>Listado de Perfiles</h2>
    <table border="1">
        <tr>
            <th>Foto</th> <!-- Nueva columna para mostrar la foto -->
            <th>Nombre</th>
            <th>Edad</th>
            <th>Profesión</th>
            <th>Visibilidad</th>
            <th>Acciones</th>
        </tr>
        <?php while ($profile = mysqli_fetch_assoc($profiles)): ?>
            <tr>
                <td>
                    <?php
                    // Crear una nueva instancia de la clase `Conexion` o usar una conexión existente
                    $conexion = new Conexion();  // Usando la conexión proporcionada

                    // Consulta para obtener la foto del perfil
                    $fotoSql = "SELECT fotop FROM fotos_perfil WHERE idperfil = '{$profile['idperfil']}' LIMIT 1";
                    $fotoResult = $conexion->consultaRetorno($fotoSql); // Ejecutar la consulta

                    // Verificar si hay una foto y mostrarla
                    if ($fotoRow = mysqli_fetch_assoc($fotoResult)) {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($fotoRow['fotop']) . '" alt="Foto de perfil" style="width: 50px; height: 50px;">';
                    } else {
                        echo 'Sin foto';
                    }
                    ?>
                </td>

                </td>
                <td><?php echo $profile['nombre'] . ' ' . $profile['apellidos']; ?></td>
                <td><?php echo $profile['edad']; ?></td>
                <td><?php echo $profile['profesion']; ?></td>
                <td><?php echo $profile['visibilidad']; ?></td>
                <td>
                    <a href="?action=editar&id=<?php echo $profile['idperfil']; ?>">Editar</a>
                    <a href="?action=eliminarFoto&id=<?php echo $profile['idperfil']; ?>" onclick="return confirm('¿Está seguro de eliminar la foto?')">Eliminar Foto</a>

                    <a href="?action=eliminar&id=<?php echo $profile['idperfil']; ?>" onclick="return confirm('¿Está seguro de eliminar este perfil?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>


    <!-- Formulario para crear un nuevo perfil -->
    <h2>Crear Nuevo Perfil</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="crear">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <label>Segundo Nombre:</label>
        <input type="text" name="segundo_nombre">
        <label>Apellido:</label>
        <input type="text" name="apellidos" required>
        <label>Segundo Apellido:</label>
        <input type="text" name="segundo_apellido">
        <label>Edad:</label>
        <input type="number" name="edad" required>
        <label>Género:</label>
        <select name="género_id">
            <option value="1">Masculino</option>
            <option value="2">Femenino</option>
            <option value="3">Otro</option>
        </select>
        <label>Visibilidad:</label>
        <select name="visibilidad">
            <option value="pública">Pública</option>
            <option value="privada">Privada</option>
        </select>
        <label>Descripción:</label>
        <input type="text" name="descripcion">
        <label>Profesión:</label>
        <input type="text" name="profesion" required>
        <label>Subir Foto:</label>
        <input type="file" name="foto">

        <button type="submit">Crear Perfil</button>
    </form>

    <!-- Formulario para editar perfil (se muestra solo si hay un perfil seleccionado) -->
    <?php if ($profileToEdit): ?>
        <h2>Editar Perfil</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="editar">
            <input type="hidden" name="idperfil" value="<?php echo $profileToEdit['idperfil']; ?>">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $profileToEdit['nombre']; ?>" required>
            <label>Segundo Nombre:</label>
            <input type="text" name="segundo_nombre" value="<?php echo $profileToEdit['segundo_nombre']; ?>">
            <label>Apellido:</label>
            <input type="text" name="apellidos" value="<?php echo $profileToEdit['apellidos']; ?>" required>
            <label>Segundo Apellido:</label>
            <input type="text" name="segundo_apellido" value="<?php echo $profileToEdit['segundo_apellido']; ?>">
            <label>Edad:</label>
            <input type="number" name="edad" value="<?php echo $profileToEdit['edad']; ?>" required>
            <label>Género:</label>
            <select name="género_id">
                <option value="1" <?php if ($profileToEdit['género_id'] == 1) echo 'selected'; ?>>Masculino</option>
                <option value="2" <?php if ($profileToEdit['género_id'] == 2) echo 'selected'; ?>>Femenino</option>
                <option value="3" <?php if ($profileToEdit['género_id'] == 3) echo 'selected'; ?>>Otro</option>
            </select>
            <label>Visibilidad:</label>
            <select name="visibilidad">
                <option value="pública" <?php if ($profileToEdit['visibilidad'] == 'pública') echo 'selected'; ?>>Pública</option>
                <option value="privada" <?php if ($profileToEdit['visibilidad'] == 'privada') echo 'selected'; ?>>Privada</option>
            </select>
            <label>Descripción:</label>
            <input type="text" name="descripcion" value="<?php echo $profileToEdit['descripcion']; ?>">
            <label>Profesión:</label>
            <input type="text" name="profesion" value="<?php echo $profileToEdit['profesion']; ?>" required>

            <label>Subir Foto:</label>
            <input type="file" name="foto">
            <button type="submit">Actualizar Perfil</button>
        </form>
    <?php endif; ?>

</body>

</html>