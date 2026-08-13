<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. ¿Está logueado? Si NO, lo mandamos al login de una
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: ../login.php?acceso=denegado");
    exit();
}

// 2. Función opcional para proteger páginas exclusivas de un ROL (ej: Admin)
function verificarRol($rolPermitido) {
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== $rolPermitido) {
        header("Location: panel.php?error=acceso_denegado");
        exit();
    }
}
?>