<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agregar";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener el último producto con id, imagen, y fecha
$sql = "SELECT id, nombre, precio, cantidad, descuento, impuesto, total, imagen, fecha FROM tabla1 ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    $data[] = $result->fetch_assoc(); // Solo el primer (último) producto
}

echo json_encode($data);

// Cerrar la conexión
$conn->close();
?>

