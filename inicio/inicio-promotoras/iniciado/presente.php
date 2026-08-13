<?php
require_once '../../administrador/verificador.php';
require_once '../../configuracion/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_grupo'])) {
    
    $dni      = $_SESSION['dni_promotoras'];
    $id_grupo = $_POST['id_grupo'];

    // Insertamos el presente con la fecha y hora exactas
    $sql = "
        INSERT INTO asistencias (id_grupos, dni_promotoras, hora_presente) 
        VALUES ('$id_grupo','$dni', NOW())
    ";

    $rel = $conn->query($sql);

    if ($rel) {
        header("Location: panel.php?msj=presente_ok");
        exit();
    } else {
        header("Location: panel.php?msj=error");
        exit();
    }
} else {
    header("Location: panel.php");
    exit();
}