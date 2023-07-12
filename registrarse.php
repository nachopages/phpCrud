<?php
session_start();
$server = "localhost";
$db_username = "root";
$password = "";
$database = "tp_final";

$db_connection = mysqli_connect($server, $db_username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $contraseña = $_POST["contraseña"];
    $re_contraseña = $_POST["re-contraseña"];

    // Verificar si el usuario ya existe en la base de datos
    $query_select = "SELECT * FROM usuario WHERE username='$usuario' OR email='$email'";
    $result_select = mysqli_query($db_connection, $query_select);

    if (mysqli_num_rows($result_select) > 0) {
        $_SESSION['error-registro'] = 'usuario_existente';
        header('Location: index.php?error=usuario_existente');
        exit;
    } elseif ($contraseña != $re_contraseña) {
        $_SESSION['error-contraseña'] = 'no_coinciden';
        header('Location: index.php?error=no_coinciden');
        exit;
    } else {
        $query_insert = "INSERT INTO `usuario`(`nombre`, `apellido`, `username`, `email`, `contraseña`) VALUES ('$nombre','$apellido','$usuario','$email','$contraseña')";
        $exe_query_insert = mysqli_query($db_connection, $query_insert);

        $_SESSION['success_message'] = "Registro completado con éxito.";

        header('Location: index.php');
        exit;
    }
}
?>