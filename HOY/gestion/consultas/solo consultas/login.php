<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre_completo']);
    $pass = $_POST['contraseña'];
    $rol = $_POST['rol']; // 'admin' o 'promotora'

    if ($rol === 'admin') {
        $stmt = $conn->prepare("SELECT dni_admin, contraseña FROM admin WHERE nombre_completo = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        // Ahora usamos password_verify para el Admin también
        if ($user && password_verify($pass, $user['contraseña'])) {
            $_SESSION['usuario'] = $user['dni_admin'];
            $_SESSION['rol'] = 'admin';
            header("Location: ../admin/dashboard.php");
        } else {
            echo "Credenciales de Admin incorrectas.";
        }
    } else {
        $stmt = $conn->prepare("SELECT dni_promotoras, contraseña FROM promotoras WHERE nombre_completo = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($pass, $user['contraseña'])) {
            $_SESSION['usuario'] = $user['dni_promotoras'];
            $_SESSION['rol'] = 'promotora';
            header("Location: ../promotoras/inicio.php");
        } else {
            echo "Credenciales de Promotora incorrectas.";
        }
    }
}
?>