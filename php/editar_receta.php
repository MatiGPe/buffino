<?php
session_start();
include 'conexion_be.php';

$id_receta = $_GET['id'];
$usuario = $_SESSION['usuario'];

// Consultar la receta por ID
$query = "SELECT * FROM recetas WHERE id = ? AND usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("is", $id_receta, $usuario);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si la receta existe y si el usuario es el creador
if ($result->num_rows === 0) {
    echo "ID de receta o usuario no válido.";
    exit();
}

$receta = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receta</title>
    <link rel="stylesheet" href="../assets/CSS/editar_receta.css">
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
        <h1>Editar Receta</h1>
    </header>

    <main>
        <form action="actualizar_receta.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_receta" value="<?php echo htmlspecialchars($receta['id']); ?>">

            <label for="nombre">Nombre de la Receta:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($receta['nombre']); ?>" required>
            
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required><?php echo htmlspecialchars($receta['descripcion']); ?></textarea>
            
            <label for="instrucciones">Instrucciones:</label>
            <textarea name="instrucciones" id="instrucciones" required><?php echo htmlspecialchars($receta['instrucciones']); ?></textarea>
            
            <label for="tiempo">Tiempo de Preparación:</label>
            <input type="text" name="tiempo" id="tiempo" value="<?php echo htmlspecialchars($receta['tiempo']); ?>" required>
            
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" required>
                <option value="Bebida" <?php echo ($receta['tipo'] === 'Bebida') ? 'selected' : ''; ?>>Bebida</option>
                <option value="Comida" <?php echo ($receta['tipo'] === 'Comida') ? 'selected' : ''; ?>>Comida</option>
                <option value="Postre" <?php echo ($receta['tipo'] === 'Postre') ? 'selected' : ''; ?>>Postre</option>
                <option value="Aderezo" <?php echo ($receta['tipo'] === 'Aderezo') ? 'selected' : ''; ?>>Aderezo</option>
                <option value="Aperitivo" <?php echo ($receta['tipo'] === 'Aperitivo') ? 'selected' : ''; ?>>Aperitivo</option>
            </select>
            
            <label for="clasificacion">Clasificación:</label>
            <select name="clasificacion" id="clasificacion" required>
                <option value="1" <?php echo ($receta['clasificacion'] === '1') ? 'selected' : ''; ?>>1</option>
                <option value="2" <?php echo ($receta['clasificacion'] === '2') ? 'selected' : ''; ?>>2</option>
                <option value="3" <?php echo ($receta['clasificacion'] === '3') ? 'selected' : ''; ?>>3</option>
                <option value="4" <?php echo ($receta['clasificacion'] === '4') ? 'selected' : ''; ?>>4</option>
                <option value="5" <?php echo ($receta['clasificacion'] === '5') ? 'selected' : ''; ?>>5</option>
            </select>
            
            <label for="dificultad">Dificultad:</label>
            <select name="dificultad" id="dificultad" required>
                <option value="Fácil" <?php echo ($receta['dificultad'] === 'Fácil') ? 'selected' : ''; ?>>Fácil</option>
                <option value="Medio" <?php echo ($receta['dificultad'] === 'Medio') ? 'selected' : ''; ?>>Medio</option>
                <option value="Difícil" <?php echo ($receta['dificultad'] === 'Difícil') ? 'selected' : ''; ?>>Difícil</option>
                <option value="Experto" <?php echo ($receta['dificultad'] === 'Experto') ? 'selected' : ''; ?>>Experto</option>
            </select>

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen">
            <p>Imagen actual: <br>
                <img src="../assets/Imagenes/<?php echo htmlspecialchars($receta['imagen']); ?>" alt="<?php echo htmlspecialchars($receta['nombre']); ?>" class="imagen-actual">
            </p>

            <button type="submit">Actualizar Receta</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Buffino. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
