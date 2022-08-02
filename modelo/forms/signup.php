<?php

include ('../connection/connection.php');
include ('../../vista/includes/header.php');

$message = '';

if (!empty($_POST['name']) && !empty($_POST['last_name']) && !empty($_POST['document_type']) && !empty($_POST['number_document'])&& !empty($_POST['email']) && !empty($_POST['password'])) {
    $sql = "INSERT INTO user (id, name, last_name, document_type, number_document, email, password, state, id_type) VALUES (id, :name, :last_name, :document_type, :number_document, :email, :password, 'Activo', 1)";
    $stmt = $conn->prepare($sql);

    
    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':last_name', $_POST['last_name']);
    $stmt->bindParam(':document_type', $_POST['document_type']);
    $stmt->bindParam(':number_document', $_POST['number_document']);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
      $message = 'Usuario Creado Exitosamente';
    } else {
      $message = 'Hubo un problema';
    }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../../vista/css/index/forms.css">
  <title>Login</title>
</head>
<body>
  
  <form action="signup.php" method="post" class="form">
    <h1 class="form__title fw-bold">Registro</h1>
    
<?php if (!empty($message)):  ?>
    <div class="alert mt-3 alert-success alert-dismissible fade show">
  <p class="text-center"><?= $message?></p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>


    <div class="form__container">
      <div class="form__group">
      <label for="text" class="form__label">Típo de documento:</label>
      </div>
      <select name="document_type" id="from__select" require>
      <option value="CC"selected="selected">Cedúla de ciudadania</option>
      <option value="CE">Cedúla de Extrangeria</option>
      <option value="TI">Tarjeta de identidad</option>
      <option value="PA">Pasaporte</option>
      </select>
      <span class="form__line"></span>
      <div class="form__group">
      <input type="number" name="number_document" class="form__input" min="6" placeholder=" "required>
      <label for="text" class="form__label">Número de identificación:</label>
      <span class="form__line"></span>
    </div>
      <div class="form__group">
      <input type="text" name="name" class="form__input" placeholder=" "required>
      <label for="text" class="form__label">Nombre:</label>
      <span class="form__line"></span>
    </div> 
      <div class="form__group">
      <input type="text" name="last_name" class="form__input" placeholder=" "required>
      <label for="text" class="form__label">Apellido:</label>
      <span class="form__line"></span>
    </div>
      <div class="form__group">
        <input type="email" name="email" class="form__input" placeholder=" "required>
      <label for="email" class="form__label">Correo:</label>
      <span class="form__line"></span>
    </div>

    <div class="form__group">
      <input type="password" name="password" class="form__input" placeholder=" "required>
      <label for="email" class="form__label">Contraseña:</label>
      <span class="form__line"></span>
    </div>
    
    <input type="submit" class="form__submit" value="Registrar">
    <p class="form__paragraph">Regresar panel <a href="../../vista/home/home_admin.php" class="form__link"> Admin</a></p>
    <!-- <p class="form__paragraph">¿Ya tienes cuenta?<a href="login.php" class="form__link"> Inicia Sesión</a></p> -->
  </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
      <script type="text/javascript" src="../../controlador/js/dinamic_styles.js"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      </body>
      </html>
