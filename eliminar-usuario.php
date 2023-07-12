<?php
session_start();

$server = "localhost";
$db_username = "root";
$password = "";
$database = "tp_final";

$db_connection = mysqli_connect($server, $db_username, $password, $database);

$id_user = $_POST['id_user'];

$query_delete = "DELETE FROM `usuario` WHERE `id_usuario` = '$id_user'";

$exe_query_delete = mysqli_query($db_connection, $query_delete);

if ($exe_query_delete) {
    header("Location: registros.php");
    exit;
} else {
    echo "Error al eliminar usuario";
}

?>