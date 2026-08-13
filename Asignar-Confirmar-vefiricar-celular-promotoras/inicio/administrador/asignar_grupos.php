<?php
require_once 'verificador.php';
require_once '../configuracion/db.php';
$mensaje = "";
// Verificamos que venga el ID del grupo a eliminar
if (isset($_POST['id_grupo'])) {
    $id_grupo =($_POST['id_grupo']);

    try {
        $conn->begin_transaction();

        // 1. Por las dudas de que no tengas configurado el "ON DELETE CASCADE" en tu base de datos,
        // borramos manualmente las relaciones en las tablas hijas para evitar errores de claves foráneas.
        
        // Borramos las promotoras asociadas al grupo
        $stmt_gp = $conn->prepare("DELETE FROM grupos_promotoras WHERE id_grupos = ?");
        $stmt_gp->bind_param("i", $id_grupo);
        $stmt_gp->execute();
        $stmt_gp->close();

        // Borramos las fechas asociadas al grupo
        $stmt_gf = $conn->prepare("DELETE FROM grupos_fechas WHERE id_grupos = ?");
        $stmt_gf->bind_param("i", $id_grupo);
        $stmt_gf->execute();
        $stmt_gf->close();

        // 2. Finalmente, borramos el grupo de la tabla principal
        $stmt_g = $conn->prepare("DELETE FROM grupos WHERE id_grupos = ?");
        $stmt_g->bind_param("i", $id_grupo);
        $stmt_g->execute();
        $stmt_g->close();

        $conn->commit();

        // Si todo sale bien, lo redirigimos de vuelta al administrador con un mensaje de éxito
        header("Location: asignar_grupos.php?mensaje=eliminado");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error al intentar borrar el grupo: " . $e->getMessage();
    }
} else

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="../estilos/grupos.css">
        <link rel="stylesheet" href="../estilos/nav.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <?php include '../estilos/nav.html'?>

    <main class="contenedor">
        <div class="titulo">

            <div class="mensaje-carga">
                <h1>Para cargar un nuevo grupo aprete el boton</h1>
            </div>
            <div class="botones">
                <button class="agregar" id="btn-agregar"><a href="./asignar.php">Asignar nuevo grupo</a></button> 
            </div>
        </div>
        <div class="formulario">
            <h2>Agregar grupo</h2>
        </div>
            <div class="prom-cargada">
            <h1>📜 Historial Grupos de promotoras</h1>
            </div>
            <div class="grupos-promotoras">
            <table>
                    <tr>
                        <th>nombre</th>
                        <th>Equipo</th>
                        <th>Tareas</th>
                        <th>Operativos</th>
                        <th>Lugar</th>
                        <th>fecha</th>
                        <th>promotoras de este grupo</th>
                        <th>borrar</th>
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
                    GROUP BY grupos.id_grupos";

                    $res_historial = $conn->query($sql_historial);  
                while($row = $res_historial->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nombre_grupo']}</td>
                            <td>{$row['numero_grupo']}</td>
                            <td>{$row['todas_las_tareas']}</td>
                            <td>{$row['operativos']}</td>
                            <td>{$row['lugar']}</td>
                            <td>{$row['todas_las_fechas']}</td>
                            <td>{$row['nombre_promotora']}</td>
                            <td>
                            <form action='' method='POST'>
                            <input type='hidden' name='id_grupo' value='{$row['id_grupos']}'>
                            <button type='submit' style='background-color: #dc3545; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer;'>
                            Borrar
                            </button>
                            </form>
                            </td>
                        </tr>";
                }
                    ?>
                </table>
                </div>
        <!-- <div class="grupo-promotoras">
            <div class="grupo">
                <i class="bi bi-people"></i>
                <h2>numero del Equipo</h2>
                <h2>tarea del equipo</h2>
                <h2>promotaras del equipo</h2>
                <h2>Horarios</h2>
                <h2>Dias</h2>
                <button class="eliminar">Eliminar</button>
            </div>
        </div> -->
    </main>
    <script src="./js/agregar-grupos.js">

    </script>
</body>
</html>