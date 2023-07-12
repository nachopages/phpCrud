<?php
session_start();
error_reporting(0);

include 'login.php';
include 'registrarse.php';

$username = $_SESSION["login-usuario"];

$query_select = "SELECT `admin` FROM usuario WHERE username = '$username'";
$result = mysqli_query($db_connection, $query_select);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $admin = $row['admin'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,-25" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Inicio</title>
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


<div class="offcanvas bg-dark offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-light" id="staticBackdropLabel">Opciones</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="text-light">
      <div class="d-grid gap-2 col-6 mx-auto">
        <?php if ($admin == 1) { ?>
          <button class="btn mt-1 mb-2 btn-success"><a href="registros.php" class="mt-1 mb-2 text-light link-offset-2 link-underline link-underline-opacity-0" data-bs-toggle="tooltip">Ver Registro</a></button>
        <?php } else { ?>
          <button class="btn mt-1 mb-2 btn-success" disabled><a href="registros.php" class="mt-1 mb-2 text-light link-offset-2 link-underline link-underline-opacity-0" data-bs-toggle="tooltip">Ver Registro</a></button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>


<?php if (isset($_SESSION['sesion'])){ ?>
          <div id="toastSesion" class="toast align-items-center mx-auto mt-3 text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex justify-content-center text-center">
              <div class="toast-body">
                <p>¡Sesion iniciada!</p>
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
<?php }?>

<?php if (isset($_SESSION['error-registro'])) { ?>
          <div id="toastSesion" class="toast align-items-center mx-auto mt-3 text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex justify-content-center text-center">
              <div class="toast-body">
                <p>¡Usuario o email ya registrados!</p>
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
<?php 
unset($_SESSION['error-registro']);
} ?>


<?php if (isset($_SESSION['success_message'])){ ?>
  <div id="toastSuccess" class="toast align-items-center text-bg-success mx-auto mt-5" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        <?php echo $_SESSION['success_message']; ?>
      </div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
<?php
unset($_SESSION['success_message']);
};
?>

<!-- Modal -->
<div class="modal fade" id="registro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Formulario de Registro</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php if (isset($_SESSION['error-contraseña']) && $_SESSION['error-contraseña'] === 'no_coinciden') { ?>
          <div class="toast align-items-center mx-auto mt-3 text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex justify-content-center text-center">
              <div class="toast-body">
                <p>¡Las contraseñas no coinciden!</p>
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
      <?php 
    unset($_SESSION['error-contraseña']);
    } ?>
      <div class="modal-body">
        <form id="registro-form" action="registrarse.php" method="post">
          <div class="form-group mb-4">
            <label for="nombre">Nombre</label>
            <input type="text" autocomplete="off" name="nombre" class="form-control" id="nombre" placeholder="Ingrese su nombre">
          </div>
          <div class="form-group mb-4">
            <label for="apellido">Apellido</label>
            <input type="text" autocomplete="off" name="apellido" class="form-control" id="apellido" placeholder="Ingrese su apellido">
          </div>
          <div class="form-group mb-4">
            <label for="usuario">Usuario</label>
            <input type="text" autocomplete="off" name="usuario" class="form-control" id="usuario" placeholder="Ingrese su nombre de usuario">
          </div>
          <div class="form-group mb-4">
            <label for="email">Correo electrónico</label>
            <input type="email" autocomplete="off" name="email" class="form-control" id="email" placeholder="Ingrese su correo electrónico">
          </div>
          <div class="form-group mb-4">
            <label for="password">Contraseña</label>
            <input type="password" autocomplete="off" name="contraseña" class="form-control" id="contraseña" placeholder="Ingrese su contraseña">
          </div>
          <div class="form-group mb-4">
            <label for="confirm-password">Repetir contraseña</label>
            <input type="password" autocomplete="off" name="re-contraseña" class="form-control" id="re-contraseña" placeholder="Repita su contraseña">
          </div>
          <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submits" autocomplete="off" class="btn mt-1 mb-2 btn-success">Registrarse</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="iniciarSesion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Iniciar Sesión</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php if (isset($_SESSION['error-sesion']) && $_SESSION['error-sesion'] === true) { ?>
          <div class="toast align-items-center mx-auto mt-1 mb-1 text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex justify-content-center text-center">
              <div class="toast-body">
                <p>¡Credenciales invalidas! Intentelo nuevamente</p>
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
      <?php 
    unset($_SESSION['error-sesion']);
    } ?>
        <form method="POST" action="login.php">
          <div class="form-group mb-4">
            <label for="nombre">Usuario</label>
            <input type="text" autocomplete="off" name="login-usuario" class="form-control" id="login-usuario" placeholder="Ingrese Usuario">
          </div>
          <div class="form-group mb-4">
            <label for="apellido">Contraseña</label>
            <input type="password" autocomplete="off" name="login-contraseña" class="form-control" id="login-contraseña" placeholder="Ingrese Contraseña">
          </div>
          <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" autocomplete="off" class="btn mt-1 mb-2 btn-success">Iniciar Sesión</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>