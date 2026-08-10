<?php
require_once '../configuracion/db.php';
$sql = "SELECT * FROM grupos";

$resultado = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Carga Automática - Solo Frontend</title>
    <link rel="stylesheet">
    <link rel="stylesheet" href="../estilos/nav.css">
    <link rel="stylesheet" href="../estilos/calendario.css">
    <!-- FullCalendar v6 -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <!-- Carga de FullCalendar en español -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js"></script>
</head>
<body>
    <?php include '../estilos/nav.html'?>
    <div id="calendar-container" >
        <!-- LEYENDA EXPLICATIVA DEL SEMÁFORO -->
        <div class="leyenda-semaforo">
            <div class="titulo">
                <h4>Referencia de Colores:</h4>
            </div>
            <div class="leyenda-items">
                <div class="item-leyenda">
                    <span class="indicador-color bg-verde"></span>
                    <span><strong>Verde:</strong> En curso (Hoy)</span>
                </div>
                <div class="item-leyenda">
                    <span class="indicador-color bg-amarillo"></span>
                    <span><strong>Amarillo:</strong> Programado (Futuro)</span>
                </div>
                <div class="item-leyenda">
                    <span class="indicador-color bg-rojo"></span>
                    <span><strong>Rojo:</strong> Finalizado (Pasado)</span>
                </div>
            </div>
        </div>
        
        <div class="grupos">
            <h2>Grupos</h2>
            <ul>
                <?php while ($row = $resultado->fetch_assoc()){?>
                <li class="promotoras-datos"><?= $row['nombre_grupo']?>
            </li>
            <div class="datos">
                <span><?= $row['numero_grupo']?></span>
                <span><?= $row['id_operativo']?></span>
                <span><?= $row['id_lugar']?></span>
            </div>

                <?php }?>
            </ul>
            
        </div>
        
        <div id="calendar"><h2 class="header-titulo">Calendario de Operativos (Carga Automática)</h2>
    </div>

        </div>

<script src="./js/calendario.js">
    </script>
</body>
</html>