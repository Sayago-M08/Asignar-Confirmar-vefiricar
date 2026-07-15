<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = intval($_POST['dni_promotoras']); // Recibimos el DNI manualmente
    $nombre = $_POST['nombre_completo'];
    $domicilio = $_POST['domicilio'];
    $pass_plana = $_POST['contraseña'];

    $pass_hash = password_hash($pass_plana, PASSWORD_DEFAULT);

    // Insertamos incluyendo el DNI
    $stmt = $conn->prepare("INSERT INTO promotoras (dni_promotoras, nombre_completo, domiciolio, contraseña) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $dni, $nombre, $domicilio, $pass_hash);

    if ($stmt->execute()) {
        echo "Promotora registrada con su DNI $dni correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
?>