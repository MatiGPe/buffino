<?php
session_start();
include 'conexion_be.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

// Consultar las recetas del usuario desde la base de datos
$query = "SELECT * FROM recetas WHERE usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Recetas</title>
    <link rel="stylesheet" href="../assets/CSS/mis_recetas.css">
</head>
<body>
    <nav>
        <div class="logo">
            <a href="../index.php">Buffino</a>
        </div>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="agregar_receta.php">Agregar Receta</a></li>
            <li><a href="mis_recetas.php">Mis Recetas</a></li>
            <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <header>
        <h1>Mis Recetas</h1>
    </header>

    <main>
        <div class="recetas-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="receta-item">
                    <a href="editar_receta.php?id=<?php echo $row['id']; ?>">
                        <img src="../assets/Imagenes/<?php echo htmlspecialchars($row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                        <div class="receta-info">
                            <h2><?php echo htmlspecialchars($row['nombre']); ?></h2>
                            <p class="descripcion"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                            <p><strong>Dificultad:</strong> <?php echo htmlspecialchars($row['dificultad']); ?></p>
                            <p><strong>Clasificación:</strong> <?php echo htmlspecialchars($row['clasificacion']); ?></p>
                            <p><strong>Tiempo:</strong> <?php echo htmlspecialchars($row['tiempo']); ?></p>
                        </div>
                        <div class="receta-buttons">
                            <a href="editar_receta.php?id=<?php echo $row['id']; ?>" class="editar-button">Editar</a>
                            <form action="eliminar_receta.php" method="POST" class="eliminar-form" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta receta?');">
                                <input type="hidden" name="id_receta" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="eliminar-button">Eliminar</button>
                            </form>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Buffino. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
