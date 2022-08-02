<?php

session_start();

include ('../connection/connection.php');

        if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $records = $conn->prepare('SELECT id, email, state, password FROM user WHERE email = :email');
        $records->bindParam(':email', $_POST['email']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        $message = '';
        if ($results['state'] === 'Inactivo') {
            $message = 'Usuario Inactivo acerquese a su centro de formación para actualizar su estado';
        }

         else if (is_countable($results) && count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
            $_SESSION['user_id'] = $results['id'];
            
          }else{
            $message = 'Datos Incorrectos';
          }
                #validar tipo de usuario
              if (isset($_SESSION['user_id'])) {
                $records = $conn->prepare('SELECT * FROM user WHERE id = :id');
                $records->bindParam(':id', $_SESSION['user_id']);
                $records->execute();
                $results = $records->fetch(PDO::FETCH_ASSOC);
                $user = null;
            
                if (count($results) > 0) {
                  $user = $results;
                  if ($user['id_type'] == 2) {
                       header('Location: ../../vista/home/home_admin.php');
                  }else if($user['id_type'] == 3){
                       header('Location: ../../vista/home/home_operator.php');
                  }else{
                       header('Location: ../../vista/home/home_user.php');
                       }
                }
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
  <link rel="stylesheet" href="../../vista/css/index/normalize.css">
  <title>Login</title>
</head>
<body>
  
  <form action="login.php" method="post" class="form">
    <h1 class="form__title fw-bold">Inicia Sesión</h1>
    
<?php if (!empty($message)):  ?>
    <div class="alert alert-danger mt-3 alert-dismissible fade show">
  <p class="text-center"><?= $message?></p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>


    <div class="form__container">
      
      <div class="form__group">
        <input type="email" name="email" class="form__input" placeholder=" " required>
      <label for="email" class="form__label">Correo:</label>
      <span class="form__line"></span>
    </div>

    <div class="form__group">
      <input type="password" name="password" class="form__input" placeholder=" " required>
      <label for="email" class="form__label">Contraseña:</label>
      <span class="form__line"></span>
    </div>

    <input type="submit" class="form__submit" value="Entrar">
    <p class="form__paragraph"><a href="../../index.html" class="form__link">Volver inicio</a></p>
  </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
      </body>
      </html>
      