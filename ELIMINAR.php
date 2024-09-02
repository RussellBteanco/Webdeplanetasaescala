<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'agregar');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener ID del formulario
$id = isset($_POST['id']) ? $_POST['id'] : '';

// Validar ID
if (!empty($id)) {
    // Preparar la consulta SQL para eliminar el producto
    $sql = "DELETE FROM tabla1 WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Producto eliminado con éxito.";
        } else {
            echo "Error al eliminar el producto: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "ID no proporcionado.";
}

// Cerrar la conexión
$conn->close();
?>
