<?php
session_start();
include 'conexion_be.php';

// Verifica si el usuario está conectado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verifica que id_receta sea válido
$id_receta = $_POST['id_receta'] ?? '';
$usuario = $_SESSION['usuario'];

if (empty($id_receta) || empty($usuario)) {
    die("ID de receta o usuario no válido.");
}

// Verificar si la receta pertenece al usuario
$query_verificacion = "SELECT 1 FROM recetas WHERE id = ? AND usuario = ?";
$stmt_verificacion = $conexion->prepare($query_verificacion);
$stmt_verificacion->bind_param("is", $id_receta, $usuario);
$stmt_verificacion->execute();
$result_verificacion = $stmt_verificacion->get_result();

if ($result_verificacion->num_rows === 0) {
    die("La receta no existe o no es tuya.");
}

// Preparar y ejecutar la consulta para eliminar la receta
$query = "DELETE FROM recetas WHERE id = ? AND usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("is", $id_receta, $usuario);

if ($stmt->execute()) {
    header("Location: mis_recetas.php");
    exit();
} else {
    echo "Error al eliminar la receta: " . $stmt->error;
}
?>
