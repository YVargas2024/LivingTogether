<?php
$controlador = new controladorUsuarios();
//validar si los datos del formulario están siendo enviados
if (isset($_POST['enviar'])) {
    $r = $controlador->crear($_POST['nombreusuario'], $_POST['correo'], $_POST['password'], $_POST['idrol']);

    if ($r) {
        echo "Se ha registrado un nuevo usuario";
    } else {
        echo "No se pudo registrar";
    }
}
?>
<style>
    /* Formulario */
    form {
        background-color: var(--white);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        margin: 0 auto;
        text-align: left;
        position: relative;
    }

    h2 {
        color: var(--blue);
        text-align: center;
        margin: 40px 0 20px;
        /* Ajuste de margen para bajar el título */
    }

    hr {
        border: none;
        height: 2px;
        background-color: var(--blue);
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-size: 1rem;
        color: #333;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        background-color: #f9f9f9;
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    select:focus {
        outline: none;
        border-color: var(--blue);
    }

    input[type="submit"] {
        width: 100%;
        background-color: var(--blue);
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #1e1a66;
    }
</style>
<h2>Creando usuarios</h2>
<hr>
<form action="" method="post">
    <label for="nombreusuario">Nombre de Usuario</label>
    <input type="text" name="nombreusuario" required>
    <br><br>
    <label for="correo">Correo</label>
    <input type="text" name="correo" required>
    <br><br>
    <label for="password">Contraseña</label>
    <input type="password" name="password" required>
    <br><br>
    <label for="rol">Rol:</label>
    <select name="idrol" id="rol" required>
        <option value="">Selecciona un rol</option>
        <option value="1" <?php echo (isset($idrol) && $idrol == 1) ? 'selected' : ''; ?>>Administrador</option>
        <option value="2" <?php echo (isset($idrol) && $idrol == 2) ? 'selected' : ''; ?>>Roomie</option>
        <option value="3" <?php echo (isset($idrol) && $idrol == 3) ? 'selected' : ''; ?>>Arrendatario</option>
    </select>
    <br><br>
    <input type="submit" name="enviar" value="Crear">
</form>