<?php
include_once("./Componentes/Header.php");
include_once("../../Controladores/ControladorPerfil.php");
$controlador = new ControladorPerfil();

// Listar perfiles
$profiles = $controlador->index($_SESSION['idusuario']); // Supone que `idusuario` está en la sesión


// Lógica para manejar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'editar') {
    $data = $_POST;
    $foto = $_FILES['foto'] ?? null; // Obtener la foto si está disponible
    $controlador->editar($_POST['idperfil'], $data, $foto);
    header("Location: editPerfil.php"); // Recargar para actualizar la lista
    exit();
}

// Lógica para manejar la eliminación
if (isset($_GET['action']) && $_GET['action'] == 'eliminar' && isset($_GET['id'])) {
    $controlador->eliminar($_GET['id']);
    header("Location: editPerfil.php"); // Recargar para actualizar la lista
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'eliminarFoto' && isset($_GET['id'])) {
    $controlador->eliminarFoto($_GET['id']);
    header("Location: editPerfil.php"); // Recargar para actualizar la lista
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
    <link rel="stylesheet" href="../../css/Roomies/editarperfil.css">
    <link rel="stylesheet" href="../../../css/header.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>


<body>

    <div class="perfilContainer">

        <?php while ($profile = mysqli_fetch_assoc($profiles)): ?>
            <div class="perfilCard">
                <?php
                // Crear una nueva instancia de la clase `Conexion` o usar una conexión existente
                $conexion = new Conexion();

                // Consulta para obtener la foto del perfil
                $fotoSql = "SELECT fotop FROM fotos_perfil WHERE idperfil = '{$profile['idperfil']}' LIMIT 1";
                $fotoResult = $conexion->consultaRetorno($fotoSql);

                // Verificar si hay una foto y mostrarla
                if ($fotoRow = mysqli_fetch_assoc($fotoResult)) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($fotoRow['fotop']) . '" alt="Foto de perfil" class="fotoRedonda">';
                } else {
                    echo '<div class="fotoRedonda">Sin foto</div>';
                }
                ?>
                <div class="EliminarFoto">
                    <a href="?action=eliminarFoto&id=<?php echo $profile['idperfil']; ?>" onclick="return confirm('¿Está seguro de eliminar la foto?')"> <ion-icon name="trash-outline"></ion-icon>Eliminar Foto</a>
                </div>
            </div>
            <div class="profile-container">
                <div class="profile-info" id="profileInfo">
                    <h3><?php echo $profile['nombre'] . ' ' . $profile['apellidos']; ?></h3>
                    <p>Edad: <?php echo $profile['edad']; ?></p>
                    <p>Profesión: <?php echo $profile['profesion']; ?></p>
                    <p>Visibilidad: <?php echo $profile['visibilidad']; ?></p>

                    <div class="perfilActions">
                        <a href="?action=editar&id=<?php echo $profile['idperfil']; ?>" onclick="showEditForm(); return false;">Editar</a><br>

                        <a href="?action=eliminar&id=<?php echo $profile['idperfil']; ?>" onclick="return confirm('¿Está seguro de eliminar este perfil?')">Eliminar</a>
                    </div>
                <?php endwhile; ?>
                </div>
                <!-- Formulario para editar perfil (se muestra solo si hay un perfil seleccionado) -->
                <?php if ($profileToEdit): ?>
                    <div class="profile-form" id="editForm" style="display: none;">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="editar">
                            <input type="hidden" name="idperfil" value="<?php echo $profileToEdit['idperfil']; ?>">

                            <div class="form-row">
                                <label>Nombre:</label>
                                <input type="text" name="nombre" value="<?php echo $profileToEdit['nombre']; ?>" required>
                                <label>Segundo Nombre:</label>
                                <input type="text" name="segundo_nombre" value="<?php echo $profileToEdit['segundo_nombre']; ?>">
                            </div>

                            <div class="form-row">
                                <label>Apellido:</label>
                                <input type="text" name="apellidos" value="<?php echo $profileToEdit['apellidos']; ?>" required>
                                <label>Segundo Apellido:</label>
                                <input type="text" name="segundo_apellido" value="<?php echo $profileToEdit['segundo_apellido']; ?>">
                            </div>

                            <div class="form-row">
                                <label>Edad:</label>
                                <input type="number" name="edad" value="<?php echo $profileToEdit['edad']; ?>" required>
                                <label>Género:</label>
                                <select name="género_id">
                                    <option value="1" <?php if ($profileToEdit['género_id'] == 1) echo 'selected'; ?>>Masculino</option>
                                    <option value="2" <?php if ($profileToEdit['género_id'] == 2) echo 'selected'; ?>>Femenino</option>
                                    <option value="3" <?php if ($profileToEdit['género_id'] == 3) echo 'selected'; ?>>Otro</option>
                                </select>
                            </div>

                            <div class="form-row">
                                <label>Visibilidad:</label>
                                <select name="visibilidad">
                                    <option value="pública" <?php if ($profileToEdit['visibilidad'] == 'pública') echo 'selected'; ?>>Pública</option>
                                    <option value="privada" <?php if ($profileToEdit['visibilidad'] == 'privada') echo 'selected'; ?>>Privada</option>
                                </select>
                                <label>Descripción:</label>
                                <input type="text" name="descripcion" value="<?php echo $profileToEdit['descripcion']; ?>">
                            </div>

                            <div class="form-row">
                                <label>Profesión:</label>
                                <input type="text" name="profesion" value="<?php echo $profileToEdit['profesion']; ?>" required>
                                <label>Subir Foto:</label>
                                <input type="file" name="foto">
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="submit-btn">Actualizar Perfil</button>
                                <button type="button" class="cancel-btn" onclick="hideEditForm()">Cancelar</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <script>
                function showEditForm() {
                    document.getElementById('profileInfo').style.display = 'none';
                    document.getElementById('editForm').style.display = 'block';
                }

                function hideEditForm() {
                    document.getElementById('profileInfo').style.display = 'block';
                    document.getElementById('editForm').style.display = 'none';
                }
            </script>

</body>

</html>