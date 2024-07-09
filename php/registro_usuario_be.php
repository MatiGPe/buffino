<?php
include 'conexion_be.php';

$usuario = $_POST['usuario'];
$nombre = $_POST['nombre'];
$clave = hash('sha512', $_POST['clave']);
$mail = $_POST['mail'];

$query = "INSERT INTO usuario (usuario, nombre, clave, mail) VALUES ('$usuario', '$nombre', '$clave', '$mail')";

$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario='$usuario'");
$verificar_mail = mysqli_query($conexion, "SELECT * FROM usuario WHERE mail='$mail'");

if (mysqli_num_rows($verificar_usuario) > 0) {
    echo '
        <script>
            alert("Este usuario ya está registrado, intenta con otro diferente");
            window.location = "../login.php";
        </script>
    ';
    exit();
}

if (mysqli_num_rows($verificar_mail) > 0) {
    echo '
        <script>
            alert("Este correo ya está registrado, intenta con otro diferente");
            window.location = "../login.php";
        </script>
    ';
    exit();
}

$ejecutar = mysqli_query($conexion, $query);

if ($ejecutar) {
    echo '
        <script>
            alert("Usuario almacenado exitosamente");
            window.location = "../login.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Error, usuario no almacenado");
            window.location = "../login.php";
        </script>
    ';
}
?>
