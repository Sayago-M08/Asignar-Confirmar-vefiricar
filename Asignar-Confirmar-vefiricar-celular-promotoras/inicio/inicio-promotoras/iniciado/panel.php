<?php
require_once '../../administrador/verificador.php';
require_once '../../configuracion/db.php';



$dni =  $_SESSION['dni_promotoras'];
$fecha_hoy    = date('Y-m-d');


$sql = " SELECT gp.*, g.*, gf.*, t.tareas

 FROM grupos_promotoras gp
 INNER JOIN grupos g ON gp.id_grupos = g.id_grupos
 INNER JOIN grupos_fechas gf ON g.id_grupos = gf.id_grupos
 INNER JOIN tareas t ON t.id_tareas = gp.id_tareas

 WHERE dni_promotoras = '$dni' AND gf.fecha = '$fecha_hoy' ";
$resultado = $conn->query($sql);


if ($resultado->num_rows > 0) {
    $asignacion = $resultado->fetch_assoc();
    $id_grupo_hoy = $asignacion['id_grupos'];
    
    $tiene_grupo_hoy = true;
    $ya_dio_presente = false;
    
    if ($tiene_grupo_hoy) {
        $sql_check = "
            SELECT *
            FROM asistencias 
            WHERE dni_promotoras = '$dni' AND id_grupos = '$id_grupo_hoy'
        ";
        $res = $conn->query($sql_check);
    
       if ($res->num_rows > 0) {
            $ya_dio_presente = true;
        } 
    }
    } else {
        $tiene_grupo_hoy = false;
        }
        ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../estilos/panel.css">
        <link rel="stylesheet" href="../estilos/nav.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    </head>
    <body>
        <?php include './nav.html'?>
        <div class="fondo-img">
            <img src="../partido_de_la_matanza.png" class="fondo">
        </div>
        <header class="cuerpo">
        <div class="contenedor-asistencia">
            </div>
            <?php if ($tiene_grupo_hoy): ?>
                <div class="alerta-exito">
                    <div class="grupo">
                        <p>Tenés asignado el grupo: <strong><?php echo $asignacion['nombre_grupo']; ?></strong> para la fecha de hoy.</p>
                    </div>
                    <div class="fecha">
                        <h1>Fechas citadas</h1>
                        <div class="fechas">
                            <ul>
                                <li><?php echo $asignacion['fecha']; ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tareas">
                        <h2>   Tareas a realizar</h2>
                        <div class="tarea">
                            <ul>
                                <li><?php echo $asignacion['tareas']; ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="fecha-dia">
                        <h2>Fecha de hoy : <?php echo $fecha_hoy ?></h2>
                        <div class="botones">
                            <?php if ($tiene_grupo_hoy && !$ya_dio_presente): ?>
                                
                                <form action="presente.php" method="POST">
                                        <input type="hidden" name="id_grupo" value="<?php echo $id_grupo_hoy; ?>">
                                    <button type="submit" class="btn-agregar">Dar Presente</button>
                                </form>
                        
                            <?php elseif ($tiene_grupo_hoy && $ya_dio_presente): ?>
                                
                                <p style="color: #38bdf8; font-weight: bold;">
                                    ✓ Presente registrado para el grupo: <?php echo $asignacion['nombre_grupo']; ?>
                                </p>
                        
                            <?php else: ?>
                                <p style="color: #94a3b8;">
                                    No tenés asignación de grupo activa para el día de hoy.
                                </p>
                        
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alerta-info">
                <div class="grupo">

                    <p>No tenés ningún grupo asignado para la jornada de hoy.</p>
                </div>
            </div>
        <?php endif; ?>


    </header>
</body>
</html>