<?php
session_start();
include 'conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$id_receta = $_POST['id_receta'];
$usuario = $_SESSION['usuario'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$instrucciones = $_POST['instrucciones'];
$tiempo = $_POST['tiempo'];
$tipo = $_POST['tipo'];
$clasificacion = $_POST['clasificacion'];
$imagen = $_FILES['imagen']['name'];
$imagen_tmp = $_FILES['imagen']['tmp_name'];
$destino = "../assets/imagenes/" . $imagen;

// Verificar que la receta pertenece al usuario
$query_verificacion = "SELECT 1 FROM recetas WHERE id = ? AND usuario = ?";
$stmt_verificacion = $conexion->prepare($query_verificacion);
$stmt_verificacion->bind_param("is", $id_receta, $usuario);
$stmt_verificacion->execute();
$result_verificacion = $stmt_verificacion->get_result();

if ($result_verificacion->num_rows === 0) {
    die("La receta no existe o no es tuya.");
}

// Si se subió una nueva imagen, actualiza el campo
if (!empty($imagen)) {
    move_uploaded_file($imagen_tmp, $destino);
    $query = "UPDATE recetas SET nombre = ?, descripcion = ?, instrucciones = ?, tiempo = ?, tipo = ?, clasificacion = ?, imagen = ? WHERE id = ? AND usuario = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssssssis", $nombre, $descripcion, $instrucciones, $tiempo, $tipo, $clasificacion, $imagen, $id_receta, $usuario);
} else {
    // Si no se subió una nueva imagen, omite el campo
    $query = "UPDATE recetas SET nombre = ?, descripcion = ?, instrucciones = ?, tiempo = ?, tipo = ?, clasificacion = ? WHERE id = ? AND usuario = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssssssis", $nombre, $descripcion, $instrucciones, $tiempo, $tipo, $clasificacion, $id_receta, $usuario);
}

if ($stmt->execute()) {
    header("Location: mis_recetas.php");
    exit();
} else {
    echo "Error al actualizar la receta: " . $stmt->error;
}
?>
