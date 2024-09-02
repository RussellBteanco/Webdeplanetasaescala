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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    
    // Descuento automático basado en la cantidad
    if ($cantidad >= 10) {
        $descuento = 10;  // 10% de descuento si la cantidad es 10 o más
    } elseif ($cantidad < 10) {
        $descuento = 5;  // 5% de descuento si la cantidad es menor a 10
    } else {
        $descuento = 0;  // Sin descuento en otros casos
    }

    // Aplicar descuento
    $precio_descuento = $precio - ($precio * $descuento / 100);

    // Aplicar impuesto automáticamente (16%)
    $impuesto = 0.16;  // 16% de impuesto
    $monto_impuesto = $precio_descuento * $impuesto;
    $precio_final = $precio_descuento + $monto_impuesto;

    // Calcular el total
    $total = $precio_final * $cantidad;

    // Mostrar el resultado
    echo "<div style='max-width: 400px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>";
    echo "<h2 style='text-align: center; color: #333;'>Resumen del Producto</h2>";
    echo "<p><strong>Nombre del Producto:</strong> " . htmlspecialchars($nombre) . "</p>";
    echo "<p><strong>Precio Original:</strong> $" . number_format($precio, 2) . "</p>";
    echo "<p><strong>Descuento Aplicado:</strong> " . $descuento . "%</p>";
    echo "<p><strong>Precio después del Descuento:</strong> $" . number_format($precio_descuento, 2) . "</p>";
    echo "<p><strong>Impuesto Aplicado:</strong> $" . number_format($monto_impuesto, 2) . " (16%)</p>";
    echo "<p><strong>Precio Unitario Final:</strong> $" . number_format($precio_final, 2) . "</p>";
    echo "<p><strong>Cantidad:</strong> " . $cantidad . "</p>";
    echo "<p><strong>Total a Pagar:</strong> $" . number_format($total, 2) . "</p>";
    echo "</div>";

    // Insertar datos en la base de datos
    $sql = "INSERT INTO tabla1 (nombre, precio, cantidad, descuento, impuesto, total)
            VALUES ('$nombre', '$precio_final', '$cantidad', '$descuento', '$monto_impuesto', '$total')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='text-align: center; color: green;'>Nuevo producto agregado exitosamente.</p>";
    } else {
        echo "<p style='text-align: center; color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    // Botón para regresar al formulario de agregar producto
    echo "<div style='text-align: center; margin-top: 20px;'>";
    echo "<a href='AGREGAR.HTML' style='display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px;'>Regresar a la seccion de agregar</a>";
    echo "</div>";
}

// Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="CONSULTAGENERAL.css">
    <style>
        
        body {
            overflow: hidden;
            background: linear-gradient(to bottom, #537596, #000);
        }
        
        .moon {
            position: absolute;
            top: 20%;
            left: 50%;
            width: 150px;
            height: 150px;
            background-color: #f1c40f;
            border-radius: 50%;
            box-shadow: 0 0 10px #f1c40f;
            transform: translateX(-50%);
        }
        .stars {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkling 1.5s infinite alternate;
        }
        @keyframes twinkling {
            0% { opacity: 1.5; }
            100% { opacity: 1; }
        }
        .star-container {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .star-container div {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkling 1.5s infinite alternate;
        }
        .star-container div:nth-child(even) { animation-duration: 2s; }
        .star-container div:nth-child(odd) { animation-duration: 1s; }
        .shooting-star {
            position: absolute;
            top: 20%;
            left: 50%;
            width: 3px;
            height: 100px;
            background: linear-gradient(white, rgba(255, 255, 255, 0));
            border-radius: 50%;
            transform: rotate(45deg);
            animation: shooting-star 3s infinite;
        }
        .shooting-star:nth-child(2) {
            animation-delay: 1s;
            left: 70%;
            animation-duration: 2s;
        }
        .shooting-star:nth-child(3) {
            animation-delay: 2s;
            left: 30%;
            animation-duration: 4s;
        }
        @keyframes shooting-star {
            0% { transform: translateY(100vh) translateX(-200vh) rotate(72deg); opacity: 1; }
            100% { transform: translateY(0) translateX(100vh) rotate(72deg); opacity: 0; }
        }
    </style>
    </head>
    <body>
    <div class="star-container">
        <div style="transform: translate(50vw, -40vh) scale(1.5);"></div>
        <div style="transform: translate(60vw, -30vh) scale(1.8);"></div>
        <div style="transform: translate(70vw, -20vh) scale(1.7);"></div>
        <div style="transform: translate(80vw, -10vh) scale(1.9);"></div>
        <div style="transform: translate(90vw, 0vh) scale(1.6);"></div>
        <div style="transform: translate(40vw, -20vh) scale(1.4);"></div>
        <div style="transform: translate(30vw, -10vh) scale(1.3);"></div>
        <div style="transform: translate(20vw, 0vh) scale(1.7);"></div>
        <div style="transform: translate(10vw, 10vh) scale(1.5);"></div>
        <div style="transform: translate(50vw, 80vh) scale(1.8);"></div>
        <div style="transform: translate(35vw, 60vh) scale(1.9);"></div>
        <div style="transform: translate(70vw, 40vh) scale(1.6);"></div>
        <div style="transform: translate(80vw, 50vh) scale(1.4);"></div>
        <div style="transform: translate(90vw, 60vh) scale(1.7);"></div>
        <div style="transform: translate(30vw, 70vh) scale(1.5);"></div>
    </div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    </body>
    </html>
