<?php 
include 'conexion_be.php';
session_start(); // Asegúrate de iniciar sesión

$id = $_GET['id'];

// Obtener detalles de la receta
$query = "SELECT * FROM recetas WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$receta = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($receta['nombre']); ?></title>
    <link rel="stylesheet" href="../assets/CSS/ver_receta.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li> <!-- Enlace a bienvenida.php -->
                <li><a href="agregar_receta.php">Agregar Receta</a></li>
                <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="receta-container">
            <img src="../assets/Imagenes/<?php echo htmlspecialchars($receta['imagen']); ?>" alt="<?php echo htmlspecialchars($receta['nombre']); ?>">
            <div class="receta-content">
                <h1><?php echo htmlspecialchars($receta['nombre']); ?></h1>
                <div class="receta-info">
                    <p><strong>Tipo:</strong> <?php echo htmlspecialchars($receta['tipo']); ?></p>
                    <p><strong>Clasificación:</strong> <?php echo htmlspecialchars($receta['clasificacion']); ?></p>
                    <p><strong>Tiempo de Preparación:</strong> <?php echo htmlspecialchars($receta['tiempo']); ?></p>
                </div>
                <p><strong>Descripción:</strong></p>
                <p><?php echo nl2br(htmlspecialchars($receta['descripcion'])); ?></p>
                <p><strong>Instrucciones:</strong></p>
                <p><?php echo nl2br(htmlspecialchars($receta['instrucciones'])); ?></p>
            </div>
        </div>
        <a href="../bienvenida.php" class="back-button">Volver a Inicio</a> <!-- Enlace a bienvenida.php -->
    </main>
</body>
</html>
