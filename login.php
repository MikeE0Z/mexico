<?php
session_start();

// Configuración de conexión
$servidor = "localhost";
$usuario = "root"; // Usuario de la base de datos
$contraseña = ""; // Contraseña de la base de datos (si existe)
$base_datos = "turismo";

// Credenciales de administrador
$admin_username = "root"; // Cambia si es necesario
$admin_password = "admin123"; // Cambia por la contraseña real

// Conexión a la base de datos
$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Verificar credenciales
if ($username === $admin_username && $password === $admin_password) {
    $_SESSION['usuario'] = $username;
    header("Location: admin.php");
    exit;
} else {
    echo "Credenciales incorrectas. Inténtalo de nuevo.";
}
?>