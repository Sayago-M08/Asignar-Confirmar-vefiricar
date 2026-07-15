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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="navegador">
        <ul class="lista">
            <a href="">
            <li class="elementos ">
                <img src="la-matanza-seeklogo.png" class="logo" style="height: 40px; width: 40px;">
                <div class="contenido">
                    <h2>La matanza</h2>
                </div>
            </li>
            </a>
            <a href="">
            <li class="elementos">
                <i class="bi bi-house"></i>

                <div class="contenido">
                    <p class="elemento-texto">Inicio</p>
                </div>
            </li>
            </a>
            <a href="index.html">
            <li class="elementos">
                <i class="bi bi-0-circle"></i>

                <div class="contenido">
                    <p class="elemento-texto">administrador</p>
                </div>
            </li>
            </a>
            <a href="registro_prom.php">
            <li class="elementos mb-3">
                <i  class="bi bi-file-earmark-person"></i>

                <div class="contenido">
                    <p class="elemento-texto">Promotoras</p>
                </div>
            </li>
            </a>
            <a href="asignar_grupos.php" >
                <li class="elementos mb-3">
                    <i class="bi bi-people"></i>

                    <div class="contenido">
                      <p class="elemento-texto">Asignar grupos</p>
                    </div>
                </li>
            </a>

            <a href="calendario.html">
            <li class="elementos mb-3">
                <i class="bi bi-calendar2-week"></i>

                <div class="contenido">
                    <p class="elemento-texto">calendario</p>
                </div>
            </li>
            </a>
                <li class="elementos">
                    <img src="" alt="" style="height: 40px;width: 40px;border-radius: 100%; background: linear-gradient(to top, rgb(15, 15, 250),rgba(0,0,0,0.5));" class="logo">
                    <div class="contenido">
                    <p class="elemento-texto">Mateo </p>
                </div>
            </li>

        </ul>
    </nav>

    <main class="conexion">
        <div class="contenedor">
            <h2>Conexion a la base de datos</h2>
        </div>
        <div class="mensaje-carga">
            <h1>Para cargar un nuevo grupo aprete el boton</h1>
        </div>
        <div class="botones">
            <button class="agregar" id="btn-agregar">Asignar nuevo grupo</button> 
        </div>
        <div class="formulario">
            <h2>Agregar grupo</h2>
            <form action="">
                <label for="">datos</label>
                <br>
                <input type="text" placeholder="dwadawd">
                <br>                <label for="">datos</label>
                <br>
                <input type="text" placeholder="dwadawd">
                <br>                <label for="">datos</label>
                <br>
                <input type="text" placeholder="dwadawd">
                <br>                <label for="">datos</label>
                <br>
                <input type="text" placeholder="dwadawd">
                <br>
            </form>
        </div>
            <div class="prom-cargada">
            <h1>📜 Historial Grupos de promotoras</h1>
            </div>
            <div class="grupos-promotoras">
            <table>

                    <tr>
                        <th>nombre</th>
                        <th>Equipo</th>
                        <th>Operativo</th>
                        <th>Tarea</th>
                        <th>Lugar</th>
                        <th>fecha</th>
                    </tr>
                    <?php
                    
                    // Esta consulta se ejecuta siempre para mostrar la tabla debajo del formulario
                    $sql_historial = "SELECT grupos.*, lugar.*, tareas.*, operaivos.*
                    FROM grupos
                    INNER JOIN lugar ON grupos.id_lugar = lugar.id_lugar
                    INNER JOIN tareas ON grupos.id_tareas = tareas.id_tareas
                    INNER JOIN operaivos ON grupos.id_operativo = operaivos.id_operativos
                    ";

                    $res_historial = $conn->query($sql_historial);  
                while($row = $res_historial->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nombre_grupo']}</td>
                            <td>{$row['numero_grupo']}</td>
                            <td>{$row['tareas']}</td>
                            <td>{$row['opearativos']}</td>
                            <td>{$row['lugar']}</td>
                            <td>{$row['fecha']}</td>
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