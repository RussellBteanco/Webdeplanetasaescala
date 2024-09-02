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
        $imgContenido = base64_encode($imagen); // Codificar a Base64

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

// Consulta para obtener el producto más reciente
$sql = "SELECT id, nombre, precio, cantidad, descuento, impuesto, total, FECHA FROM tabla1 ORDER BY FECHA DESC LIMIT 1"; 
$result = $conn->query($sql);

// Variable para almacenar los datos del producto
$row = null;
$producto = null;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $producto = $row['nombre']; // o $row['id'], dependiendo de cómo quieras buscar la imagen
}

// Cerrar la conexión con la base de datos
$conn->close(); 

// Conectar a la base de datos de imágenes
$conn_images = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn_images->connect_error) {
    die("Conexión fallida: " . $conn_images->connect_error);
}

// Consulta para obtener la imagen del producto desde la base de datos
$imgSrc = "";
if ($producto) {
    $sql_image = "SELECT imagen FROM precioproductos WHERE nombre = '$producto'"; // Ajusta el nombre de la tabla y campo según tu base de datos
    $result_image = $conn_images->query($sql_image);

    if ($result_image->num_rows > 0) {
        $row_image = $result_image->fetch_assoc();
        $imgData = $row_image['imagen']; // Imagen en Base64
        $imgSrc = "data:image/jpeg;base64,$imgData"; // Ajusta el tipo MIME según el formato de tu imagen
    }
}

// Cerrar la conexión con la base de datos de imágenes
$conn_images->close(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Recientes</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="CONSULTAGENERAL.css">
    <style>
        .product-image {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div id="stars"></div>
<div id="stars2"></div>
<div id="stars3"></div>
<div class="section"></div>
    <div class="container">
        <h1>Productos Recientes</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Impuesto</th>
                    <th>Total</th>
                    <th>Imagen</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if ($row) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["id"]) . "</td>
                            <td>" . htmlspecialchars($row["nombre"]) . "</td>
                            <td>" . htmlspecialchars(number_format($row["precio"], 2)) . "</td>
                            <td>" . htmlspecialchars($row["cantidad"]) . "</td>
                            <td>" . htmlspecialchars(number_format($row["descuento"], 2)) . "</td>
                            <td>" . htmlspecialchars(number_format($row["impuesto"], 2)) . "</td>
                            <td>" . htmlspecialchars(number_format($row["total"], 2)) . "</td>
                            <td><img src='" . $imgSrc . "' alt='Imagen de producto' class='product-image'></td>
                            
                        </tr>";
                } else {
                    echo "<tr><td colspan='9'>No se encontraron productos recientes</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
