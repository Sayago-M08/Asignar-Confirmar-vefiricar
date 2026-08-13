<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../configuracion/db.php';

$sql = "SELECT 
            gf.id_grupos_fechas AS id,
            gf.id_grupos AS id_grupo_num,
            gf.fecha AS start,
            g.nombre_grupo AS nombre
        FROM grupos_fechas gf
        INNER JOIN grupos g ON gf.id_grupos = g.id_grupos
        "
        ;

$res = $conn->query($sql);
$eventos = array();

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $eventos[] = array( 
            'id'    => (string)$row['id'],
            'title' => "Grupo " . $row['nombre'], // FullCalendar exige que title sea un String
            'start' => (string)$row['start'],           // Debe ser formato YYYY-MM-DD
            'extendedProps' => array(
                'id_grupo' => $row['id_grupo_num']
            )
        );
    }
}

echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
?>