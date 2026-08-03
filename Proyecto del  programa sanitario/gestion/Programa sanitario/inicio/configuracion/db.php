<?php
// Configuración de los datos de tu servidor local (XAMPP / MariaDB)
$host = "localhost";
$user = "root";       // Usuario por defecto de XAMPP
$password = "";       // Contraseña por defecto de XAMPP (vacía)
$database = "gestionn"; // El nombre exacto de tu base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar si hay algún error en la conexión
if ($conn->connect_error) {
    die("❌ Error catastrófico de conexión: " . $conn->connect_error);
}

// Forzar el juego de caracteres a utf8mb4 para que no tengas problemas 
// con las eñes (como en tu columna 'contraseño') o los acentos.
$conn->set_charset("utf8mb4");
?>