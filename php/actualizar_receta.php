<?php
session_start();
include 'conexion_be.php';

$id_receta = $_POST['id_receta'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$instrucciones = $_POST['instrucciones'];
$tiempo = $_POST['tiempo'];
$tipo = $_POST['tipo'];
$clasificacion = $_POST['clasificacion'];
$dificultad = $_POST['dificultad'];
$imagen = $_FILES['imagen']['name'];
$imagen_tmp = $_FILES['imagen']['tmp_name'];

// Obtener el nombre de usuario desde la sesión
$usuario = $_SESSION['usuario'];

// Consultar la receta para verificar que el usuario sea el creador
$query = "SELECT usuario FROM recetas WHERE id = ? AND usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("is", $id_receta, $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "ID de receta o usuario no válido.";
    exit();
}

// Si se subió una nueva imagen, actualiza el archivo
if ($imagen) {
    $destino = "../assets/Imagenes/" . $imagen;
    move_uploaded_file($imagen_tmp, $destino);
    $query = "UPDATE recetas SET nombre = ?, descripcion = ?, instrucciones = ?, tiempo = ?, tipo = ?, clasificacion = ?, dificultad = ?, imagen = ? WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssssssssi", $nombre, $descripcion, $instrucciones, $tiempo, $tipo, $clasificacion, $dificultad, $imagen, $id_receta);
} else {
    $query = "UPDATE recetas SET nombre = ?, descripcion = ?, instrucciones = ?, tiempo = ?, tipo = ?, clasificacion = ?, dificultad = ? WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssssssi", $nombre, $descripcion, $instrucciones, $tiempo, $tipo, $clasificacion, $dificultad, $id_receta);
}

if ($stmt->execute()) {
    header("Location: mis_recetas.php");
} else {
    echo "Error al actualizar la receta";
}
?>
