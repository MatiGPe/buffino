<?php
session_start();
include 'conexion_be.php';

$mail = $_POST['mail'];
$clave = hash('sha512', $_POST['clave']);

$query = "SELECT * FROM usuario WHERE mail='$mail' AND clave='$clave'";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);
    $_SESSION['usuario'] = $row['usuario'];
    header("Location: ../index.php");
    exit();
} else {
    echo '
        <script>
            alert("Usuario o contraseña incorrectos");
            window.location = "../login.php";
        </script>
    ';
    exit();
}
?>
