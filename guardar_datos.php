<?php
// Configuración de la base de datos
$servidor = "localhost";
$usuario = "tu_usuario";
$contraseña = "tu_contraseña";
$base_datos = "turismo";

// Crear conexión
$conn = new mysqli($servidor, $usuario, $contraseña, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Insertar datos si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO clientes (nombre, email, telefono, descripcion) VALUES ('$nombre', '$email', '$telefono', '$descripcion')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Los datos se guardaron correctamente.";
    } else {
        echo "Error al guardar los datos: " . $conn->error;
    }
}

// Eliminar registro si se solicita
if (isset($_GET['eliminar_id'])) {
    $id = $_GET['eliminar_id'];
    $sql = "DELETE FROM clientes WHERE id = $id";
    $conn->query($sql);
    header("Location: ".$_SERVER['PHP_SELF']); // Redirige para evitar reenvío al actualizar
    exit;
}

// Obtener todos los registros de la tabla "clientes"
$sql = "SELECT * FROM clientes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .delete-btn {
            color: red;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Registro de Clientes</h2>

    <!-- Formulario para agregar clientes -->
    <form method="POST" action="">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br>
        
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        
        <label>Teléfono:</label><br>
        <input type="text" name="telefono" required><br>
        
        <label>Descripción:</label><br>
        <textarea name="descripcion" required></textarea><br><br>
        
        <button type="submit" name="agregar">Agregar Cliente</button>
    </form>

    <h2>Lista de Clientes</h2>
    
    <!-- Tabla de clientes -->
    <table>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['nombre'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['telefono'] . "</td>
                        <td>" . $row['descripcion'] . "</td>
                        <td><a href='?eliminar_id=" . $row['id'] . "' class='delete-btn'>&times;</a></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay clientes registrados</td></tr>";
        }
        ?>
    </table>

    <?php
    // Cerrar conexión
    $conn->close();
    ?>
</body>
</html>