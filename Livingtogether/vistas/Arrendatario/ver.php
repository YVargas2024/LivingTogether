<?php
include_once("../../Controladores/Crud_hab/Controlador.php");

// Verificar si se proporcionó 'idhabitacion' en la URL
if (isset($_GET['idhabitacion'])) {
    $controlador = new controladorHabitaciones();
    $row = $controlador->ver($_GET['idhabitacion']); // Obtener detalles de la habitación seleccionada
    if (!$row) {
        // Si no se encuentra la habitación, redirigir
        header('Location: arrendatario.php');
        exit();
    }
} else {
    // Si no se proporciona 'idhabitacion', redirigir
    header('Location: arrendatario.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../css/Arrendatario/ver.css">
    <?php
    include_once("./Componentes/Header.php"); ?>
</head>
<style>
    :root {
        --main-color: #54372a;
        --second-color: #df582e;
        --text-color: #060413;
        --container-color: #f8e4be;
        --bg-color: #f9f6f2;
        --text-alter-color: #94908e;
        --font-family: "Viga", sans-serif;
    }

    body {
        font-family: var(--font-family);
        background-color: var(--bg-color);
        margin: 0;
        padding: 0;
    }

    .custom-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
        background-color: var(--container-color);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        font-size: 16px;
    }

    .custom-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .custom-card-header {
        background-color: var(--main-color);
        color: white;
        padding: 20px;
        text-align: center;
        font-size: 1.5rem;
        border-bottom: 2px solid var(--second-color);
    }

    .custom-card-body {
        padding: 20px;
    }

    .custom-img-fluid {
        width: 100%;
        /* Mantiene el ancho al 100% del contenedor */
        max-height: 300px;
        /* Limita la altura máxima a 300px (ajústalo según tus necesidades) */
        object-fit: cover;
        /* Hace que la imagen cubra el área sin distorsionarse */
    }

    .custom-info-container {
        padding: 20px;
        background-color: var(--container-color);
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .custom-info-container h3 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: var(--main-color);
    }

    .custom-info-container p {
        font-size: 18px;
        margin-bottom: 10px;
        color: var(--text-color);
    }

    .custom-btn {
        padding: 10px 20px;
        font-size: 1rem;
        background-color: var(--second-color);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        margin-top: 20px;
        transition: background-color 0.3s ease;
    }

    .custom-btn:hover {
        background-color: var(--main-color);
    }

    .custom-btn i {
        margin-right: 8px;
    }

    /* Estilos para el modal */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .custom-modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 80%;
        max-height: 80vh;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .custom-modal img {
        max-width: 100%;
        height: auto;
    }

    .custom-modal-close {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--main-color);
    }
</style>

<body>
    <br>
    <br>
    <div class="custom-container">
        <div class="custom-card">
            <div class="custom-card-header">
                <h2>Habitación <?php echo $row['idhabitacion']; ?></h2>
            </div>
            <div class="custom-card-body">
                <div class="row">
                    <!-- Imagen de la habitación -->
                    <div class="col-12 mb-4">
                        <?php if (!empty($row['foto'])): ?>
                            <img src="<?php echo $row['foto']; ?>" alt="Foto de la habitación" class="custom-img-fluid" id="imgThumbnail" />
                        <?php else: ?>
                            <p>No hay foto disponible.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Lado inferior: Información -->
                    <div class="col-12">
                        <div class="custom-info-container">
                            <h3>Detalles de la Habitación</h3>
                            <p><strong>Dirección:</strong> <?php echo $row['direccion']; ?></p>
                            <p><strong>Descripción:</strong> <?php echo $row['descripcion']; ?></p>
                            <p><strong>Precio:</strong> $<?php echo number_format($row['precio'], 2); ?></p>
                            <p><strong>Fecha de Publicación:</strong> <?php echo date('d/m/Y', strtotime($row['fechapublicacion'])); ?></p>
                            <p><strong>Estado:</strong> <?php echo $row['estado']; ?></p>
                            <br>
                            <!-- Botón de WhatsApp -->
                            <?php if ($row['estado'] === 'disponible' && !empty($row['telefono'])): ?>
                                <a href="https://wa.me/<?php echo $row['telefono']; ?>?text=<?php echo urlencode('Hola, estoy interesado en la habitación ' . $row['idhabitacion']); ?>" class="custom-btn" target="_blank">
                                    <i class="fa-brands fa-whatsapp" style="color: #63E6BE; font-size: 20px;"></i> Contactar
                                </a>
                            <?php else: ?>
                                <button class="custom-btn disabled-btn" disabled>No disponible</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver la imagen en tamaño original -->
    <div class="custom-modal" id="imageModal">
        <div class="custom-modal-content">
            <span class="custom-modal-close" id="closeModal">&times;</span>
            <img id="modalImage" src="" alt="Imagen Original" />
        </div>
    </div>
    <?php include_once("../comentarios/ver.php") ?>
    <script>
        // Función para mostrar la imagen en el modal
        document.addEventListener("DOMContentLoaded", function() {
            var imgThumbnail = document.getElementById("imgThumbnail");
            var modal = document.getElementById("imageModal");
            var modalImg = document.getElementById("modalImage");
            var closeModal = document.getElementById("closeModal");

            // Cuando se hace clic en la imagen
            imgThumbnail.onclick = function() {
                modal.style.display = "flex"; // Mostrar el modal
                modalImg.src = imgThumbnail.src; // Establecer la imagen del modal
            }

            // Cerrar el modal cuando se hace clic en la X
            closeModal.onclick = function() {
                modal.style.display = "none"; // Ocultar el modal
            }

            // Cerrar el modal si se hace clic fuera de la imagen
            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>

</body>

</html>