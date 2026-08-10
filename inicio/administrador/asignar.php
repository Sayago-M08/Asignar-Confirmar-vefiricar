<?php
require_once '../configuracion/db.php';

$sql = "SELECT * FROM promotoras";
$rel = $conn->query($sql);

$sql_tareas = "SELECT * FROM tareas";
$rel_tareas = $conn->query($sql_tareas);

$sql_operativos = "SELECT * FROM operaivos"; 
$rel_operativos = $conn->query($sql_operativos);

$sql_lugar = "SELECT * FROM lugar";
$rel_lugar = $conn->query($sql_lugar);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Capturamos las variables fijas del grupo (ya sin fecha_grupo)
    $numero_grupo     = $_POST['num'];
    $nombre_grupo     = $_POST['nom'];
    $nombre_lugar     = $_POST['nombre_lugar'];
    $nombre_operativo = $_POST['nombre_operativo'];

    // Capturamos las variables dinámicas de fechas (array)
    $fechas_array     = $_POST['fechas']; // Viene del input name="fechas[]"

    // Capturamos las variables dinámicas de asignación (arrays)
    $promotoras_array = $_POST['promotora'];
    $tareas_array     = $_POST['nombre_tarea'];

    // Validamos campos obligatorios, que al menos haya una fecha y una promotora
    if (!empty($nombre_grupo) && !empty($nombre_lugar) && !empty($nombre_operativo) && !empty($fechas_array[0]) && !empty($promotoras_array[0])) {
        
        try {
            $conn->begin_transaction();

            // 1. Buscamos o creamos el LUGAR
            $stmt_l = $conn->prepare("SELECT id_lugar FROM lugar WHERE lugar = ?");
            $stmt_l->bind_param("s", $nombre_lugar);
            $stmt_l->execute();
            $res_l = $stmt_l->get_result();

            if ($row_l = $res_l->fetch_assoc()) {
                $id_lugar = $row_l['id_lugar'];
            } else {
                $stmt_il = $conn->prepare("INSERT INTO lugar (lugar) VALUES (?)");
                $stmt_il->bind_param("s", $nombre_lugar);
                $stmt_il->execute();
                $id_lugar = $conn->insert_id;
                $stmt_il->close();
            }
            $stmt_l->close();

            // 2. Buscamos o creamos el OPERATIVO
            $stmt_o = $conn->prepare("SELECT id_operativos FROM operaivos WHERE operativos = ?");
            $stmt_o->bind_param("s", $nombre_operativo);
            $stmt_o->execute();
            $res_o = $stmt_o->get_result();

            if ($row_o = $res_o->fetch_assoc()) {
                $id_operativo = $row_o['id_operativos'];
            } else {
                $stmt_io = $conn->prepare("INSERT INTO operaivos (operativos) VALUES (?)");
                $stmt_io->bind_param("s", $nombre_operativo);
                $stmt_io->execute();
                $id_operativo = $conn->insert_id;
                $stmt_io->close();
            }
            $stmt_o->close();

            // =================================================================
            // 3. CREAMOS EL GRUPO UNA SOLA VEZ (AFUERA DE LOS BUCLES)
            // =================================================================
            // Notar que ya NO insertamos la fecha acá
            $sql_grupo = "INSERT INTO grupos (numero_grupo, nombre_grupo, id_operativo, id_lugar) VALUES (?, ?, ?, ?)";
            $stmt_g = $conn->prepare($sql_grupo);
            $stmt_g->bind_param("isii", $numero_grupo, $nombre_grupo, $id_operativo, $id_lugar);
            $stmt_g->execute();
            
            $id_grupo_nuevo = $conn->insert_id; // Obtenemos el ID único del grupo creado
            $stmt_g->close();

            // =================================================================
            // 4. BUCLE PARA ASOCIAR LAS MÚLTIPLES FECHAS AL GRUPO
            // =================================================================
            $sql_fecha = "INSERT INTO grupos_fechas (id_grupos, fecha) VALUES (?, ?)";
            $stmt_gf = $conn->prepare($sql_fecha);

            foreach ($fechas_array as $fecha) {
                if (!empty($fecha)) {
                    $stmt_gf->bind_param("is", $id_grupo_nuevo, $fecha);
                    $stmt_gf->execute();
                }
            }
            $stmt_gf->close();

            // =================================================================
            // 5. BUCLE PARA ASOCIAR LAS PROMOTORAS Y SUS TAREAS AL GRUPO
            // =================================================================
            for ($i = 0; $i < count($promotoras_array); $i++) {
                
                $dni_promotora = $promotoras_array[$i];
                $nombre_tarea  = $tareas_array[$i];

                if (empty($dni_promotora) || empty($nombre_tarea)) {
                    continue;
                }

                // Buscamos o creamos la TAREA para esta promotora en particular
                $stmt_t = $conn->prepare("SELECT id_tareas FROM tareas WHERE tareas = ?");
                $stmt_t->bind_param("s", $nombre_tarea);
                $stmt_t->execute();
                $res_t = $stmt_t->get_result();

                if ($row_t = $res_t->fetch_assoc()) {
                    $id_tarea = $row_t['id_tareas'];
                } else {
                    $stmt_it = $conn->prepare("INSERT INTO tareas (tareas) VALUES (?)");
                    $stmt_it->bind_param("s", $nombre_tarea);
                    $stmt_it->execute();
                    $id_tarea = $conn->insert_id;
                    $stmt_it->close();
                }
                $stmt_t->close();

                // Vinculamos la promotora, la tarea y el grupo
                $sql_intermedia = "INSERT INTO grupos_promotoras (id_grupos, dni_promotoras, id_tareas) VALUES (?, ?, ?)";
                $stmt_i = $conn->prepare($sql_intermedia);
                $stmt_i->bind_param("isi", $id_grupo_nuevo, $dni_promotora, $id_tarea);
                $stmt_i->execute();
                $stmt_i->close();
            }

            $conn->commit();
            header("Location: asignar_grupos.php?mensaje=eliminado");

        } catch (Exception $e) {
            $conn->rollback();
            echo "<h1>Hubo un error al procesar la carga</h1>";
            echo "<p>Detalles: " . $e->getMessage() . "</p>";
        }

    } else {
        echo "<h1>Campos incompletos en el formulario.</h1>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación de Promotoras</title>
    <link rel="stylesheet" href="../estilos/asignar.css">
    <link rel="stylesheet" href="../estilos/nav.css">
    <style>
    
    </style>
</head>
<body>
    <?php include '../estilos/nav.html'?>
    <form action="" method="POST" >
        <div class="input-principal">

        <!-- DATOS GENERALES DEL GRUPO (FIJOS) -->
         <div class="num-grupo">

             <label for="num">Elije el número del grupo</label>
             <input type="number" id="num" name="num" placeholder="Ingrese el número del grupo" required>
             
         </div>
         <div class="nombre-grupo">
            
             <label for="nom">Nombre del grupo</label>
             <input type="text" id="nom" name="nom" placeholder="Ingrese el nombre del grupo" required>
             
         </div>
        
        <!-- Buscador / Creador de Lugar (Fijo) -->
        <div class="formulario-grupo">
            <label for="buscador-lugar">Asignar/Crear Lugar:</label>
            <input 
            list="lista-lugares" 
            id="buscador-lugar" 
            name="nombre_lugar" 
            placeholder="Escribí para buscar/crear..."  
            autocomplete="off"
            required
            >
            <datalist id="lista-lugares">
                <?php while ($row = $rel_lugar->fetch_assoc()){ ?>
                <option value="<?= $row['lugar'] ?>"></option>
                <?php } ?>
            </datalist>
        </div>
        
        <!-- Buscador / Creador de Operativos (Fijo) -->
        <div class="formulario-grupo">
            <label for="buscador-operativo">Asignar/Crear Operativo:</label>
            <input 
            list="lista-operativos" 
            id="buscador-operativo" 
            name="nombre_operativo" 
            placeholder="Escribí para buscar/crear..." 
            autocomplete="off"
            required
            >
            <datalist id="lista-operativos">
                <?php while ($row = $rel_operativos->fetch_assoc()){ ?>
                <option value="<?= $row['operativos'] ?>"></option>
                <?php } ?>
            </datalist>
        </div>
        <div class="contenedor-fecha">
            <h3>Fechas de Trabajo del Grupo</h3>
            
            <!-- Contenedor donde se irán sumando los inputs de fecha -->
            <div id="contenedor-fechas">
                <div class="fila-fecha" style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                    <input type="date" name="fechas[]">
                    <span class="fecha-inicio">(Fecha inicial)</span>
                </div>
            </div>
            
            <!-- Botón para agregar más campos de fecha -->
            <div class="boton">
                
                <button type="button" id="btn-agregar-fecha" class="btn-agregar">
                    + Agregar otra fecha
                </button>
            </div>
        </div>
    </div>


<div class="segundos-input">

        <div id="contenedor-asignaciones" class="contenedor-secundario">
            
            <!-- Bloque 1 (Por defecto) -->
            <div class="bloque-asignacion">
                <h3>Asignación 1</h3>

                <!-- 1. Buscador Promotoras -->
                <div class="formulario-grupo">
                    <label>Asignar Promotora:</label>
                    <input 
                        list="promotoras" 
                        name="promotora[]" 
                       placeholder="Escribí para buscar/crear..." 
                        autocomplete="off"
                        required
                    >
                </div>

                <!-- 2. Buscador / Creador de Tareas -->
                <div class="formulario-grupo">
                    <label>Asignar/Crear Tarea:</label>
                    <input 
                        list="lista-tareas" 
                        name="nombre_tarea[]" 
                        placeholder="Escribí para buscar/crear..." 
                        autocomplete="off"
                        required
                    >
                </div>

                <button type="button" class="btn-eliminar" onclick="eliminarFila(this)" style="display: none; background-color: #ff4d4d; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-top: 10px;">Eliminar Asignación</button>
            </div>
        </div>

        <!-- Botón para agregar más duplicados -->
        <button type="button" id="btn-agregar-asignacion" class="btn-agregar">
            + Agregar otra Promotora y Tarea
        </button>

        <br>
        <div class="btn-enviar">

            <input type="submit" value="Enviar" class="enviar">
        </div>
    </form>

    <!-- Datalists globales para las opciones dinámicas -->
    <datalist id="promotoras">
        <?php 
        $rel->data_seek(0);
        while ($row = $rel->fetch_assoc()){ ?>
            <option value="<?= $row['dni_promotoras'] ?>"><?= $row['nombre_completo'] ?></option>
        <?php } ?>
    </datalist>

    <datalist id="lista-tareas">
        <?php 
        $rel_tareas->data_seek(0);
        while ($row = $rel_tareas->fetch_assoc()){ ?>
            <option value="<?= $row['tareas'] ?>"></option>
        <?php } ?>
    </datalist>
 </div>
    <script src="./js/agregar-grupos.js"></script>
</body>
</html>