<?php include_once('./Componentes/Sidebar.php'); ?>
<?php
require_once __DIR__ . '/../../Controladores/EstadisticasController.php';

$controller = new EstadisticasController();
$estadisticas = $controller->mostrarEstadisticas();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Estadísticas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        h1 {
            color: black;
            font-size: 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .card-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            padding: 30px;
            margin-left: 40px;
            justify-content: center;
            margin-bottom: 30px;
            /* Centra las tarjetas en el contenedor */
        }

        .card {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            /* Reducido el padding */
            width: 140px;
            /* Reducido el tamaño de las cartas */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            margin: 10px;
            /* Espacio adicional entre las cartas */
        }

        .card h2 {
            font-size: 1.2em;
            /* Reducido el tamaño del texto */
            margin: 8px 0;
        }

        .card p {
            font-size: 0.9em;
            /* Reducido el tamaño del texto */
            color: #666;
        }

        .card i {
            font-size: 1.6em;
            /* Reducido el tamaño del icono */
            color: black;
            position: absolute;
            top: 5px;
            right: 5px;
            opacity: 0.3;
            /* Hace el icono más tenue para un efecto visual */
        }
    </style>
</head>

<body>
    <div class="card-container">
        <div class="card">
            <i class="fas fa-bed"></i>
            <h2><?php echo $estadisticas['total_habitaciones']; ?></h2>
            <p>Total de Habitaciones</p>
        </div>
        <div class="card">
            <i class="fas fa-door-open"></i>
            <h2><?php echo $estadisticas['habitaciones_disponibles']; ?></h2>
            <p>Habitaciones Disponibles</p>
        </div>
        <div class="card">
            <i class="fas fa-door-closed"></i>
            <h2><?php echo $estadisticas['habitaciones_no_disponibles']; ?></h2>
            <p>Habitaciones No Disponibles</p>
        </div>
        <div class="card">
            <i class="fas fa-users"></i>
            <h2><?php echo $estadisticas['total_usuarios']; ?></h2>
            <p>Total de Usuarios</p>
        </div>
        <div class="card">
            <i class="fas fa-user-shield"></i>
            <h2><?php echo $estadisticas['usuarios_administrador']; ?></h2>
            <p>Administradores</p>
        </div>
        <div class="card">
            <i class="fas fa-user-friends"></i>
            <h2><?php echo $estadisticas['usuarios_roomie']; ?></h2>
            <p>Roomies</p>
        </div>
        <div class="card">
            <i class="fas fa-user"></i>
            <h2><?php echo $estadisticas['usuarios_arrendatario']; ?></h2>
            <p>Arrendatarios</p>
        </div>
    </div>
    <h1>Estadísticas</h1>
    <canvas id="estadisticasChart" width="400" height="100"></canvas> <!-- Reduced height -->

    <script>
        const data = {
            labels: ['Total Habitaciones', 'Habitaciones Disponibles', 'Habitaciones No Disponibles',
                'Total Usuarios', 'Administradores', 'Roomies', 'Arrendatarios'
            ],
            datasets: [{
                label: 'Estadísticas',
                data: [
                    <?php echo $estadisticas['total_habitaciones']; ?>,
                    <?php echo $estadisticas['habitaciones_disponibles']; ?>,
                    <?php echo $estadisticas['habitaciones_no_disponibles']; ?>,
                    <?php echo $estadisticas['total_usuarios']; ?>,
                    <?php echo $estadisticas['usuarios_administrador']; ?>,
                    <?php echo $estadisticas['usuarios_roomie']; ?>,
                    <?php echo $estadisticas['usuarios_arrendatario']; ?>
                ],
                fill: false,
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.4, // Adding some smoothness to the line
                borderWidth: 2
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                animations: {
                    tension: {
                        duration: 1000, // Duration of the animation
                        easing: 'linear', // Easing function for smoothness
                        from: 1, // Starting tension value
                        to: 0, // Ending tension value (smooth line)
                        loop: true // Loop the animation
                    }
                },
                scales: {
                    y: {
                        min: 0, // Set minimum value of the Y-axis
                        max: 100 // Set maximum value of the Y-axis
                    }
                },
                responsive: true
            }
        };

        const ctx = document.getElementById('estadisticasChart').getContext('2d');
        const estadisticasChart = new Chart(ctx, config);
    </script>

</body>

</html>