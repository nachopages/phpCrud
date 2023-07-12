<?php
session_start();

$server = "localhost";
$db_username = "root";
$password = "";
$database = "tp_final";

$db_connection = mysqli_connect($server, $db_username, $password, $database);



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["login-usuario"];
    $contraseña = $_POST["login-contraseña"];

    $query_select = "SELECT id_usuario FROM usuario WHERE username = '$username' AND contraseña = '$contraseña'";
    $exe_query_select = mysqli_query($db_connection, $query_select);
    $_SESSION["usuario-logeado"] = $username;

    if (mysqli_num_rows($exe_query_select) == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION["login-usuario"] = $username;
        $_SESSION["sesion"] = "iniciada";
        header("Location: index.php?sesion=iniciada");
        exit;
    } else{
        $_SESSION["error-sesion"] = true;
        header('Location: index.php?error-sesion=credenciales-invalidas');
        exit;
    }

}

?>