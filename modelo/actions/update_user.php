<?php

include '../connection/connection2.php';
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
        $query = "SELECT * FROM user WHERE id = $id";
          $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $name= $row['name'];
        $last_name= $row['last_name'];
        $state= $row['state'];
      }

    }

if (isset($_POST['update'])) { 
  $id = $_GET['id'];
  $query2 = "SELECT name, last_name FROM user WHERE id ='$id'";
  $result2 = mysqli_query($conn, $query2);
  $row = mysqli_fetch_array($result2);

  $state= $_POST['changeState'];

  $query = "UPDATE user SET state = '$state' WHERE id = '$id'";
  mysqli_query($conn, $query);

  function deleteDirectory($dir) {
    if(!$dh = @opendir($dir)) return;
    while (false !== ($current = readdir($dh))) {
        if($current != '.' && $current != '..') {
            if (!@unlink($dir.'/'.$current)) 
                deleteDirectory($dir.'/'.$current);
        }       
    }
    closedir($dh);
    @rmdir($dir);
}
deleteDirectory("../../controlador/codeqr/codes/".$row['name']."-".$row['last_name']."-".$id);

header("Location: ../../vista/home/home_admin.php");
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

<form action="update_user.php?id=<?php echo $_GET['id']?>" class="form" method="POST">
<h1 class="form__title fw-bold">Actualizar Estado: <?php echo $name, ' ', $last_name ?></h1>

<div class="form-group mt-5 mb-5">
<select class="form-select  mb-3 text-center" name="changeState">
            <option 
            <?php if ($state == 'Activo') {
            echo "selected";    
            }
            ?>
            >Activo</option>
            <option 
            <?php if ($state == 'Inactivo') {
            echo "selected";    
            }
            ?>
            >Inactivo</option>
            </select>
</div>

<input type="submit" name="update" class="btn btn-dark col-12 p-2 " value="Actualizar">

<a href="../../vista/home/home_admin.php" class="btn btn-dark col-12 p-2 mt-2 mb-3">Volver</a>
<style>
  .btn-dark{
    border:none;
  }
</style>

</form>
      </body>
      </html>

