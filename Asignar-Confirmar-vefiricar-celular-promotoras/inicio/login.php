<?php
session_start();
require_once './configuracion/db.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturamos el DNI (lo pasamos a entero para que coincida con la DB) y la clave
    $dni_ingresado = intval($_POST['dni']);
    $password = $_POST['password'];

    // 1. INTENTAMOS LOGUEAR COMO PROMOTORA (Usando 'dni_promotoras')
    $stmt = $conn->prepare("SELECT dni_promotoras, nombre_completo, contraseña FROM promotoras WHERE dni_promotoras = ?");
    $stmt->bind_param("i", $dni_ingresado);
    $stmt->execute();
    $res_promo = $stmt->get_result();

    if ($res_promo->num_rows === 1) {
        $promotora = $res_promo->fetch_assoc();
        
        if ($password === $promotora['contraseña']) {
            // Login exitoso Promotora
            $_SESSION['rol'] = 'promotora';
            $_SESSION['dni_promotoras'] = $promotora['dni_promotoras'];
            $_SESSION['nombre'] = $promotora['nombre'];
            $_SESSION['logueado']   = true;
            
            header("Location:./inicio-promotoras/iniciado/panel.php");
            exit();
        } else {
            $mensaje = "<span class='mersaje_error' style='color:red;'>La contraseña es incorrecta.</span>";
        }
    } else {
        // 2. SI NO ERA PROMOTORA, INTENTAMOS LOGUEAR COMO ADMINISTRADOR (Usando 'dni_admin')
        $stmt_admin = $conn->prepare("SELECT dni_admin, nombre_completo, contraseña FROM admin WHERE dni_admin = ?");
        $stmt_admin->bind_param("i", $dni_ingresado);
        $stmt_admin->execute();
        $res_admin = $stmt_admin->get_result();

        if ($res_admin->num_rows > 0) {
            $admin = $res_admin->fetch_assoc();
            
            if ($password == $admin['contraseña']) {
                // Login exitoso Administrador
                $_SESSION['rol'] = 'admin';
                $_SESSION['dni_admin'] = $admin['dni_admin'];
                $_SESSION['nombre'] = $admin['nombre'];
                $_SESSION['logueado']   = true;
                
                header("Location:./administrador/calendario.php");
                exit();
            } else {
                $mensaje = "<span class='mersaje_error' style='color:red;'>La contraseña es incorrecta.</span>";
            }
        } else {
            // No se encontró el DNI en ninguna de las dos tablas
            $mensaje = "<span class='mersaje_error'>El DNI ingresado no se encuentra registrado.</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Programa Sanitario</title>
    <link rel="stylesheet" href="./estilos/style_inicio_sesion.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>Proyecto practicas</title>
    <link rel="icon" href="/la-matanza-seeklogo.png">
</head>
<body>
    <div class="alerta">

        <?php if(!empty($mensaje)) echo "<p><b>$mensaje</b></p>"; ?>
    </div>

    <div class="contenedor  d-flex align-items-center justify-content-center">
          
          <div class="contenido border  p-3 text-light rounded-4" >
              
              <form class="text-center" action="" method="post">
                  <div class="titulo">
    
                      <h2 class="d-flex justify-content-center">inicio de sesion</h2>
                  </div>
                  <div class="row d-grid">
                  <div class="col ">
                      <label class="mt-3" for="">Dni</label>
                      <br>
                      <input class="input-dato mb-3 form-control " type="int" name="dni" placeholder="Ingrese su dni" required>
    
                  </div>
                  <div class="col">
    
                      <label for="">contraseña</label>
                      <br>
                      <input class="input-dato mb-3 form-control " type="password" name="password" placeholder="contraseña" required>
                  </div>
    
                  <div class="col">
                      
                      <input class="boton-input mb-3" type="submit" name="enviar" value="enviar">
                  </div>
                  </div>
                  
                  <div class="col">
    
                      <button class="boton-olvidar"><a href="./registrar.php" class="boton">¿olvido su contraseña?</a></button>
                  </div>
    
              </form>
          </div>
             
      </div>

</body>
</html>
