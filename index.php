<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: php/login.php");
    exit();
}

include 'php/conexion_be.php'; // Asegúrate de incluir la conexión a la base de datos

$usuario = $_SESSION['usuario'];
$query = "SELECT * FROM recetas WHERE usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('s', $usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Buffino</title>
    <link rel="stylesheet" href="assets/CSS/bienvenida.css">
</head>
<body>
    <nav>
        <div class="logo">
            <a href="index.php">Buffino</a>
        </div>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="php/agregar_receta.php">Agregar Receta</a></li>
            <li><a href="php/mis_recetas.php">Mis Recetas</a></li>
            <li><a href="php/cerrar_sesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
    </header>

    <main>
        <section>
            <h2>Tus Recetas</h2>
            <div class="recetas-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="receta-item">
                            <a href="php/ver_receta.php?id=<?php echo $row['id']; ?>">
                                <img src="assets/imagenes/<?php echo htmlspecialchars($row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                                <h2><?php echo htmlspecialchars($row['nombre']); ?></h2>
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No tienes recetas aún.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Buffino. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
