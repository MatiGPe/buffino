<?php
session_start();
include 'conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $instrucciones = $_POST['instrucciones'];
    $tiempo = $_POST['tiempo'];
    $tipo = $_POST['tipo'];
    $clasificacion = $_POST['clasificacion'];
    $usuario = $_SESSION['usuario'];

    $url = 'https://api.postimages.org/1/upload';
    $apiKey = 'YOUR_API_KEY';
    $image = $_FILES['imagen']['tmp_name'];

    $cFile = new CURLFile($image);
    $postFields = array('key' => $apiKey, 'image' => $cFile);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    if (isset($result['data']['url'])) {
        $imageURL = $result['data']['url'];

        $query = "INSERT INTO recetas (nombre, descripcion, instrucciones, tiempo, tipo, clasificacion, imagen, usuario) 
                  VALUES ('$nombre', '$descripcion', '$instrucciones', '$tiempo', '$tipo', '$clasificacion', '$imageURL', '$usuario')";
        $ejecutar = mysqli_query($conexion, $query);

        if ($ejecutar) {
            echo '
                <script>
                    alert("Receta almacenada exitosamente");
                    window.location = "bienvenida.php";
                </script>
            ';
            exit();
        } else {
            echo '
                <script>
                    alert("Error, receta no almacenada");
                    window.location = "bienvenida.php";
                </script>
            ';
            exit();
        }
    } else {
        echo '
            <script>
                alert("Error al subir la imagen");
                window.location = "add_receta.php";
            </script>
        ';
        exit();
    }
}
?>
