<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Receta</title>
    <link rel="stylesheet" href="../assets/CSS/agregar_receta.css">
</head>
<body>
    <nav>
        <div class="logo">
            <a href="index.php">Buffino</a>
        </div>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="agregar_receta.php">Agregar Receta</a></li>
            <li><a href="mis_recetas.php">Mis Recetas</a></li>
            <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <main>
        <h1>Agregar Nueva Receta</h1>
        <form action="add_receta_be.php" method="POST" enctype="multipart/form-data">
    <label for="nombre">Nombre de la Receta:</label>
    <input type="text" name="nombre" id="nombre" required>
    
    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion" required></textarea>
    
    <label for="instrucciones">Instrucciones:</label>
    <textarea name="instrucciones" id="instrucciones" required></textarea>
    
    <label for="tiempo">Tiempo de Preparación:</label>
    <input type="text" name="tiempo" id="tiempo" required>
    
    <label for="tipo">Tipo:</label>
    <select name="tipo" id="tipo" required>
        <option value="Bebida">Bebida</option>
        <option value="Comida">Comida</option>
        <option value="Postre">Postre</option>
        <option value="Aderezo">Aderezo</option>
        <option value="Aperitivo">Aperitivo</option>
    </select>
    
    <label for="clasificacion">Clasificación:</label>
    <select name="clasificacion" id="clasificacion" required>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    
    <label for="dificultad">Dificultad:</label>
    <select name="dificultad" id="dificultad" required>
        <option value="Fácil">Fácil</option>
        <option value="Medio">Medio</option>
        <option value="Difícil">Difícil</option>
        <option value="Experto">Experto</option>
    </select>

    <label for="imagen">Imagen:</label>
    <input type="file" name="imagen" id="imagen" required>

    <button type="submit">Agregar Receta</button>
</form>

    </main>
</body>
</html>
