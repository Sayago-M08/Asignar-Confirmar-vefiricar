<?php
require_once '../configuracion/db.php';
 $hoy = date('Y-m-d');
$sql = "SELECT grupos.*,grupos_fechas.*
FROM grupos
INNER JOIN grupos_fechas ON grupos.id_grupos = grupos_fechas.id_grupos
-- El WHERE siempre va AL FINAL de todos los JOIN, nunca en el medio
WHERE grupos_fechas.fecha = '$hoy'";
$res = $conn->query($sql);

$sql_promotoras="SELECT grupos.*, lugar.*,tareas.*, operaivos.*,promotoras.*
                    FROM grupos
                    INNER JOIN lugar ON grupos.id_lugar = lugar.id_lugar
                    INNER JOIN operaivos ON grupos.id_operativo = operaivos.id_operativos


                    inner JOIN grupos_fechas ON grupos.id_grupos = grupos_fechas.id_grupos

                    INNER JOIN grupos_promotoras ON grupos.id_grupos = grupos_promotoras.id_grupos
                    INNER JOIN tareas ON grupos_promotoras.id_tareas = tareas.id_tareas
                    INNER JOIN promotoras ON grupos_promotoras.dni_promotoras = promotoras.dni_promotoras
            WHERE grupos_fechas.fecha ='$hoy'";

$promo= $conn->query($sql_promotoras);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="../estilos/principal.css">
        <link rel="stylesheet" href="../estilos/nav.css">
</head>
<body>
    <?php include '../estilos/nav.html'?>

    <main class="conexion">
            <div class="prom-cargada">
            <h1>Promotoras Citados Hoy <?= $hoy  ?></h1>
            </div>

        <div class="promotoras">
            <?php  if ($promo && $promo->num_rows > 0) {?>

            <?php while($resultado = $promo->fetch_array()){?>
            <div class="promotoras-datos">
                <i class="bi bi-person"></i>
                <h2>Nombre: <?=  $resultado['nombre_completo'] ?></h2>
                <h2>Domicilio: <?=  $resultado['domicilio'] ?></h2>
                <h2>Barrio: <?=  $resultado['barrio'] ?> </h2>
                <button class="confirmar">Inasistente</button>
            </div>
            <?php }} else{
                echo "<p class='msj'>No hay promotoras para hoy.</p>";
            }
            ?>
        </div>
            <div class="prom-cargada">
            <h1>Grupos de Citados hoy <?= $hoy ?></h1>
            </div>
            <?php
                if ($res && $res->num_rows > 0) {?>

<div class="grupo-promotoras">
                <table>

            <tr>
                <th>nombre</th>
                <th>Equipo</th>
                <th>Operativo</th>
                <th>Tarea</th>
                <th>Lugar</th>
                <th>fecha</th>
                <th>promotoras de este grupo</th>
            </tr>
            <?php
            
            // Esta consulta se ejecuta siempre para mostrar la tabla debajo del formulario
            $sql_historial = "SELECT grupos.*, lugar.*,tareas.*, operaivos.*,promotoras.*,
                    GROUP_CONCAT(DISTINCT DATE_FORMAT(grupos_fechas.fecha, '%d/%m/%Y') SEPARATOR ', ') AS todas_las_fechas,
                    GROUP_CONCAT(DISTINCT tareas.tareas SEPARATOR ', ') AS todas_las_tareas,
                    GROUP_CONCAT(DISTINCT promotoras.nombre_completo SEPARATOR ', ') AS nombre_promotora
                    FROM grupos
                    INNER JOIN lugar ON grupos.id_lugar = lugar.id_lugar
                    INNER JOIN operaivos ON grupos.id_operativo = operaivos.id_operativos


                    inner JOIN grupos_fechas ON grupos.id_grupos = grupos_fechas.id_grupos

                    INNER JOIN grupos_promotoras ON grupos.id_grupos = grupos_promotoras.id_grupos
                    INNER JOIN tareas ON grupos_promotoras.id_tareas = tareas.id_tareas
                    INNER JOIN promotoras ON grupos_promotoras.dni_promotoras = promotoras.dni_promotoras
            WHERE grupos_fechas.fecha ='$hoy'
            ";

            $res_historial = $conn->query($sql_historial);  
        while($row = $res_historial->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nombre_grupo']}</td>
                    <td>{$row['numero_grupo']}</td>
                    <td>{$row['tareas']}</td>
                    <td>{$row['operativos']}</td>
                    <td>{$row['lugar']}</td>
                    <td>{$row['todas_las_fechas']}</td>
                    <td>{$row['nombre_promotora']}</td>
                </tr>";
        }
            ?>
        </table>

                <?php
                } else {
                    echo "<p class='msj'>No hay registros para hoy.</p>";
                }
                ?>
        </div>
    </main>
</body>
</html>