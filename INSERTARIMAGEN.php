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

// Manejo del formulario para agregar productos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    // Verificar si se ha subido una imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        // Obtener el archivo de imagen y convertirlo a Base64
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        $imgContenido = base64_encode($imagen); // Codificar el contenido de la imagen a Base64

        // Preparar la consulta para evitar inyecciones SQL
        $sql = $conn->prepare("INSERT INTO precioproductos (nombre, precio, imagen) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $nombre, $precio, $imgContenido);

        if ($sql->execute()) {
            echo "<p style='text-align: center; color: green;'>Producto agregado exitosamente.</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>Error: " . $sql->error . "</p>";
        }

        // Cerrar la consulta
        $sql->close();
    } else {
        echo "<p style='text-align: center; color: red;'>Error al subir la imagen.</p>";
    }
}

// Cerrar la conexión
$conn->close();
?>
