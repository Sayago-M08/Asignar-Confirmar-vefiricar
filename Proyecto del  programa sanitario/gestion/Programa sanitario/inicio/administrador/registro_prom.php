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
        <link rel="stylesheet" href="../estilos/nav.css">
</head>
<body>
        <?php include '../estilos/nav.html'?>
    <main class="conexion">
        <div class="prom-cargada">
            <h1>Promotoras en el sistema</h1>
        </div>
        <div class="buscador">
            <form action="" method="POST">
                <div class="form-input">
                    <input type="text" name="busqueda" placeholder="domicilio" class="texto">
                    <input type="submit" name="enviar" value="Buscar" class="boton">
                </div>
            </form>
        </div>
        <div class="promotoras">
            <?php
            if(isset($_POST['enviar'])){
                $busqueda = $_POST['busqueda'];
                $sql_busqueda = "SELECT * FROM promotoras WHERE nombre_completo LIKE '%$busqueda%' OR dni_promotoras LIKE '%$busqueda%' OR domicilio LIKE '%$busqueda%' OR barrio LIKE '%$busqueda%'";
                $bus =  $conn->query($sql_busqueda);
                while($p = $bus->fetch_assoc()) {
                     ?>
            <div class="promotoras-datos">
                <i class="bi bi-person"></i>
                <h2>dni: <?=  $p['dni_promotoras'] ?></h2>
                <h2>Nombre:<?=  $p['nombre_completo'] ?></h2>
                <h2>domicilio:  <?=  $p['domicilio'] ?></h2>
                <h2>Barrio: <?=  $p['barrio'] ?></h2>
                <div class="botones">
                <button class="actualizar">Actualizar</button> <button class="eliminar">Eliminar</button>
                </div>
            </div>
            <?php
                }
            }else{
                $res_p = $conn->query("SELECT * FROM promotoras");
                while($p = $res_p->fetch_assoc()) {
                    ?>
                    <div class="promotoras-datos">
                        <i class="bi bi-person"></i>
                        <h2>dni: <?=  $p['dni_promotoras'] ?></h2>
                        <h2>Nombre:<?=  $p['nombre_completo'] ?></h2>
                        <h2>domicilio:  <?=  $p['domicilio'] ?></h2>
                        <h2>Barrio: <?=  $p['barrio'] ?></h2>
                        <div class="botones">
                        <button class="actualizar">Actualizar</button> <button class="eliminar">Eliminar</button>
                        </div>
                    </div>
                    <?php
                }}
            ?>
    </main>
</body>
</html>