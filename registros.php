<?php
session_start();
error_reporting(0);

$server = "localhost";
$db_username = "root";
$password = "";
$database = "tp_final";

include 'login.php';


$db_connection = mysqli_connect($server, $db_username, $password, $database);

$username = $_SESSION["login-usuario"];
// Consultar los registros de la base de datos
$query_select = "SELECT * FROM usuario";
$exe_query = mysqli_query($db_connection, $query_select);

$query_select_admin = "SELECT `admin` FROM usuario WHERE username = '$username'";
$result = mysqli_query($db_connection, $query_select_admin);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $admin = $row['admin'];

    if ($admin == 0) {
        header("Location: index.php");
    } 
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,-25" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Registros</title>
</head>
<body>
    
<nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { ?>

          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop" aria-current="page" href="#">Opciones</a>
          </li>
          <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
              <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <button class="btn btn-dark dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                          <span class="material-symbols-outlined">person</span>
                          <?php echo "<p class='mb-0 ms-2'>$username</p>" ?>
                      </button>

                      <ul class="dropdown-menu dropdown-menu-dark">
                          <li><a class="dropdown-item" href="#">Ver Perfil</a></li>
                          <li><a class="dropdown-item" href="logout.php" >Cerrar Sesion</a></li>
                      </ul>
                      
                  </li>
          </div>

        <?php } else{ ?>
          
          <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
              <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <button class="btn btn-dark dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                          <span class="material-symbols-outlined">person</span>
                          <p class="mb-0 ms-2">Usuario</p>
                      </button>

                      <ul class="dropdown-menu dropdown-menu-dark">
                          <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#registro" href="#">Registrarse</a></li>
                          <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#iniciarSesion" href="index.php">Iniciar Sesion</a></li>
                      </ul>
                      
                  </li>
          </div>
         <?php }?> 
      </ul>
    </div>
  </div>
</nav>

<div class="container">
        <h1>Registros</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Contraseña</th>
                    <th>Admin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($exe_query)) { ?>
    <tr>
        <td><?php echo $row['id_usuario']; ?></td>
        <td><?php echo $row['nombre']; ?></td>
        <td><?php echo $row['apellido']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['contraseña']; ?></td>
        <td>
            <div class='form-check form-switch'>
                <input disabled class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" <?php echo $row['admin'] ? 'checked' : ''; ?>>
            </div>
        </td>
        <td>
            <?php echo "<a class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modificar{$row['id_usuario']}'>modificar</a> <a id='eliminar{$row['id_usuario']}' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#eliminar{$row['id_usuario']}'>eliminar</a>"; ?>
        </td>
    </tr>

    <div class="modal fade" id="modificar<?php echo $row['id_usuario'];?>" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Modificar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="modificar-usuario.php">
                        <div class="mb-3">
                            <input type="hidden" autocomplete="off" name="id_user" value="<?php echo $row['id_usuario'];?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="modificar-firstname" class="form-label">Nombre:</label>
                            <input type="text" autocomplete="off" name="nombre" value="<?php echo $row['nombre'];?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="modificar-lastname" class="form-label">Apellido:</label>
                            <input type="text" autocomplete="off" name="apellido" value="<?php echo $row['apellido'];?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="modificar-username" class="form-label">Usuario:</label>
                            <input type="text" autocomplete="off" name="username" value="<?php echo $row['username'];?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="modificar-email" class="form-label">Email:</label>
                            <input type="email" autocomplete="off" name="email" value="<?php echo $row['email'];?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="modificar-admin" class="form-label">Admin:</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="admin" type="checkbox" role="switch" id="flexSwitchCheckDefault" <?php echo $row['admin'] ? 'checked' : ''; ?>>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modificar-password" class="form-label">Contraseña:</label>
                            <input type="text" autocomplete="off" name="password" value="<?php echo $row['contraseña'];?>" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eliminar<?php echo $row['id_usuario'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                    <p>Usuario: <?php echo $row['username']; ?></p>

                    <form action="eliminar-usuario.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $row['id_usuario']; ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>