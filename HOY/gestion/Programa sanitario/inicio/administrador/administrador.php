<?php
require_once '../configuracion/db.php';
 $hoy = date('Y-m-d');
$sql = "SELECT * FROM promotoras";

$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="../estilos/principal.css">
</head>
<body>
    <?php include '../estilos/nav.html'?>

    <main class="conexion">
        <div class="contenedor">
            <h2>Conexion a la base de datos</h2>
        </div>
            <div class="prom-cargada">
            <h1>Promotoras Citados Hoy <?= $hoy  ?></h1>
            </div>
        <div class="promotoras">
            <?php while($resultado = $res->fetch_array()){?>
            <div class="promotoras-datos">
                <i class="bi bi-person"></i>
                <h2>Nombre: <?=  $resultado['nombre_completo'] ?></h2>
                <h2>Domicilio: <?=  $resultado['domiciolio'] ?></h2>
                <h2>Barrio: <?=  $resultado['barrio'] ?> </h2>
                <button class="actualizar">Actualizar</button> <button class="eliminar">Eliminar</button>
            </div>
            <?php }?>
        </div>
            <div class="prom-cargada">
            <h1>Grupos de Citados hoy <?= $hoy ?></h1>
            </div>
        <div class="grupo-promotoras">
                <!-- <?php
                if ($res && $res->num_rows > 0) {
                    echo "<table border='1'><tr><th>Operativo</th><th>N° Equipo</th><th>Tarea</th><th>Lugar</th><th>Promotoras</th></tr>";
                    while ($row = $res->fetch_assoc()) {
                        echo "<tr><td>{$row['operativo']}</td><td>Equipo {$row['numero']}</td><td>{$row['tarea']}</td><td>{$row['lugar']}</td><td>{$row['lista_promotoras']}</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No hay registros para hoy.</p>";
                }
                ?> -->
        </div>
    </main>
</body>
</html>