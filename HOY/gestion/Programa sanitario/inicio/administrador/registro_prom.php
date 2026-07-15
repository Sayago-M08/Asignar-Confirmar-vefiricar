<?php
require_once '../configuracion/db.php';
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
            <h1>Promotoras en el sistema</h1>
            </div>
        <div class="promotoras">
        <?php
        $res_p = $conn->query("SELECT * FROM promotoras");
        while($p = $res_p->fetch_assoc()) {
            ?>
            <div class="promotoras-datos">
                <i class="bi bi-person"></i>
                <h2>Nombre:<?=  $p['nombre_completo'] ?></h2>
                <h2>Apellido:  <?=  $p['domiciolio'] ?></h2>
                <h2>Localidad:  <?=  $p['barrio'] ?></h2>
                <div class="botones">
                <button class="actualizar">Actualizar</button> <button class="eliminar">Eliminar</button>
                </div>
            </div>
            <?php
        }
        ?>
    </main>
</body>
</html>