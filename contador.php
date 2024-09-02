<?php
// Nombre del archivo donde se almacenará el contador
$archivoContador = 'contador.txt';

// Verificar si el archivo existe
if (!file_exists($archivoContador)) {
    // Si no existe, crear el archivo y establecer el contador en 0
    file_put_contents($archivoContador, 0);
}

// Leer el contador actual
$contador = (int)file_get_contents($archivoContador);

// Incrementar el contador
$contador++;

// Guardar el nuevo valor del contador en el archivo
file_put_contents($archivoContador, $contador);

// Enviar el número de vistas al navegador
echo $contador;
?>
