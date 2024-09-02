<?php
$host = 'localhost';
$dbname = 'COMENTARIOS'; // Cambia esto según tu base de datos
$username = 'root'; // Cambia esto según tu configuración
$password = ''; // Cambia esto según tu configuración

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = htmlspecialchars($_POST['nombre']);
        $comentario = htmlspecialchars($_POST['comentario']);

        $stmt = $pdo->prepare("INSERT INTO TABLA1 (nombre, comentario) VALUES (:nombre, :comentario)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':comentario', $comentario);

        if ($stmt->execute()) {
            echo "Comentario guardado exitosamente.";
        } else {
            echo "Error al guardar el comentario.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header("Location: " . $_SERVER['HTTP_REFERER']); // Redirige de vuelta a la página anterior
?>
