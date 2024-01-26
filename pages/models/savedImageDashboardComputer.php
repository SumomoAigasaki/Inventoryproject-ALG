<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $base64_image = $_POST['image'];
    $file_name = $_POST['filename'];

    // Decodificar la imagen base64
    $decoded_image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_image));

    // Ruta de la carpeta donde quieres guardar las imágenes
    $folder_path = '../../resources/Dashboard/Computer/';

    // Guardar la imagen en la carpeta especificada
    file_put_contents($folder_path . $file_name, $decoded_image);
    echo 'Imagen guardada exitosamente en el servidor en la carpeta ' . $folder_path;
} else {
    echo 'Error: Método de solicitud incorrecto';
}
?>