<?php
session_start();

$server = "localhost";
$db_username = "root";
$password = "";
$database = "tp_final";

$db_connection = mysqli_connect($server, $db_username, $password, $database);

$id_user = $_POST['id_user'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

if (isset($_POST['admin'])) {
    $admin = 1;
} else {
    $admin = 0;
}

$query_update = "UPDATE `usuario` SET `nombre`='$nombre', `apellido`='$apellido', `username`='$username', `email`='$email', `admin`='$admin', `contraseña`='$password' WHERE `id_usuario` = '$id_user'";

$exe_query = mysqli_query($db_connection, $query_update);

if ($exe_query) {
    header('Location: registros.php');
} else {
    echo "Error al actualizar el usuario. Por favor, inténtalo de nuevo.";
}
?>

