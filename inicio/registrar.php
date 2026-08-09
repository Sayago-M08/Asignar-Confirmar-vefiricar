<?php
require_once './configuracion/db.php';
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = intval($_POST['dni_promotoras']); // Recibimos el DNI manualmente
    $nombre = $_POST['nombre'];
    $domicilio = $_POST['domicilio'];
    $barrio = $_post['barrio'];
    $pass_plana = $_POST['contraseña'];

    //verificacion
    $sql_dni = "SELECT * FROM promotoras WHERE dni_promotoras ='$dni'";
    $dni_verificar = $conn ->query($sql_dni);

    if($dni_verificar && $dni_verificar->num_rows >0){
        $mensaje = "<span class='msj_error'>Promotora ya registrada</span>";
    }else{
        // Insertamos incluyendo el DNI
        $stmt = $conn->prepare("INSERT INTO promotoras (dni_promotoras, nombre_completo, domicilio,barrio contraseña) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isss", $dni, $nombre, $domicilio, $barrio, $pass_plana);
        if ($stmt->execute()) {
            $mensaje = "Promotora registrada correctamente.";
        } else {
            echo "Error: ";
        }
        
        $stmt->close();
    }
    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Promotoras</title>
    <link rel="stylesheet" href="./estilos/style_registrar_promotora.css">
</head>
<body>
    
        <?php if(!empty($mensaje)) echo "<p class='msj'><b>$mensaje</b></p>"; ?>
        
        <div class="form-registrar">
        <h2>Registro de Promotoras 📋</h2>
        <form  action="" method="POST">
            <label for="">Ingresar dni de la promotora</label>
            <input type="number" name="dni_promotoras" placeholder="Número de DNI" ><br><br>

            <label for="">Ingresar nombre de la promotora</label>
            <input type="text" name="nombre" placeholder="Nombre" ><br><br>

            <label for="">Ingresar contraseña de la promotora</label>
            <input type="password" name="contraseña" placeholder="Contraseña" ><br><br>

            <label for="">ingresar domicilio de la promotora</label>
            <input type="text" name="domicilio" placeholder="domicilio" ><br><br>

            <label for="">ingresar barrio de la promotora</label>
            <input type="text" name="barrio" placeholder="barrio" ><br><br>

            <button type="submit" class="btn-registrar">Registrar Promotora</button>
        </form>

    </div>
</body>
</html>