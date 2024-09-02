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

// Obtener el texto de búsqueda desde la solicitud
$q = $_GET['q'];

// Preparar y ejecutar la consulta
$sql = "SELECT nombre, precio FROM PRECIOPRODUCTOS WHERE nombre LIKE ?";
$stmt = $conn->prepare($sql);
$search = '%' . $q . '%';
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

// Recopilar los resultados
$suggestions = [];
while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row;
}

// Cerrar la conexión
$stmt->close();
$conn->close();

// Devolver las sugerencias en formato JSON
header('Content-Type: application/json');
echo json_encode($suggestions);
?>
