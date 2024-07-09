<?php
session_start();
include 'conexion_be.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtiene los datos del formulario
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$instrucciones = $_POST['instrucciones'];
$tiempo = $_POST['tiempo'];
$tipo = $_POST['tipo'];
$clasificacion = $_POST['clasificacion'];
$usuario = $_SESSION['usuario']; // Aquí se asume que 'usuario' es el nombre del usuario

// Verifica si se ha subido una imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
    $imagen = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    $destino = "../assets/imagenes/".$imagen;

    if (move_uploaded_file($imagen_tmp, $destino)) {
        // Inserta los datos de la receta en la base de datos
        $query = "INSERT INTO recetas (nombre, descripcion, instrucciones, tiempo, tipo, clasificacion, imagen, usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssssssss", $nombre, $descripcion, $instrucciones, $tiempo, $tipo, $clasificacion, $imagen, $usuario);

        if ($stmt->execute()) {
            // Redirige a la página de "Mis Recetas" con un mensaje de éxito
            header("Location: mis_recetas.php?mensaje=Receta agregada con éxito");
        } else {
            echo "Error al agregar la receta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al subir la imagen.";
    }
} else {
    echo "No se ha subido ninguna imagen.";
}

$conexion->close();
?>
