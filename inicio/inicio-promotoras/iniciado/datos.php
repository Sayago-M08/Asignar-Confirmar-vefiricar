<?php

require_once '../../administrador/verificador.php';
require_once '../../configuracion/db.php';

    $dni      = $_SESSION['dni_promotoras'];
$sql= "SELECT * FROM promotoras WHERE dni_promotoras = '$dni'";
$rel = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="../estilos/datos.css">
<link rel="stylesheet" href="../estilos/nav.css">
<link rel="stylesheet" href="../estilos/panel.css">
<body>
       <div class="fondo-img">

        <img src="../partido_de_la_matanza.png" class="fondo">
    </div>
    <?php include './nav.html'?>
    <header class="principal">
        <div class="icono">
            <i class="bi bi-person-vcard"></i>
        </div>
        <div class="datos">
            <ul>
                <?php while ($resultado = $rel->fetch_assoc()){
    
?>
                <li>Nombre
                    <div class="datos-personales ">
                        <h3><?= $resultado['nombre_completo']?></h3>
                    </div>
                </li>
                <li>domicilio
                    <div class="datos-personales ">
                        <h3><?= $resultado['domicilio']?></h3>
                    </div>
                </li>
                <li>barrio
                    <div class="datos-personales ">
                        <h3><?= $resultado['barrio']?></h3>
                    </div>
                </li>
                <li>contraseña
                    <div class="datos-personales ">
                        <h3>*****</h3>
                    </div>
                </li>
                              <?php 
    
}?>
            </ul>
        </div>
    </header>
</body>
</html>