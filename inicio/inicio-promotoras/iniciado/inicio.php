<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../../configuracion/db.php'; 

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: login.php");
    exit();
}

$nombre_usuario = $_SESSION['nombre'] ?? 'Usuario';
$rol_usuario    = $_SESSION['rol'] ?? 'Promotora';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programa Sanitario - Inicio</title>
    <link rel="stylesheet" href="../estilos/nav.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../estilos/inicio.css">
</head>
<body>
        <div class="fondo-img">

        <img src="../partido_de_la_matanza.png" class="fondo">
        </div>
    <?php include './nav.html'?>

    <!-- Contenido Principal -->
    <main class="container">
        
        <div class="welcome-card">
            <h1>¡Hola, <span><?php echo ($nombre_usuario); ?></span>!</h1>
            <p>Bienvenido al sistema de gestión sanitaria. Seleccioná una opción para comenzar.</p>
        </div>

        <!-- Opciones del Menú -->
        <div class="grid-menu">
            
            <a href="./panel.php" class="menu-card">
                <div>
                    <h3>Asistencia</h3>
                    <p>Marcar presente para la jornada asignada hoy.</p>
                </div>
                <span class="badge">Dar Presente</span>
            </a>

            <?php if ($rol_usuario === 'administrador'): ?>
            <a href="reportes.php" class="menu-card">
                <div>
                    <h3>Reportes</h3>
                    <p>Exportar datos de asistencia y citados en Excel.</p>
                </div>
                <span class="badge">Administración</span>
            </a>
            <?php endif; ?>

        </div>

    </main>

</body>
</html>