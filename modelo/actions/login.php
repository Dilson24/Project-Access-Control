<?php
include_once '../connection/connection2.php';
$email = $_POST['text'];

//consultar si el email esta en la base de datos
$consultEmail = "SELECT * FROM user WHERE email ='$email'";
$query = mysqli_query($conn, $consultEmail);
$row = mysqli_fetch_array($query);
$id = $row['id'];
$state = $row['state'];

if ($row > 0 ) {
      if ($state === 'Activo') {
         $sql = "SELECT * FROM access WHERE id_user='$id' AND deserted IS NULL AND date = CURDATE()";
         $query = mysqli_query($conn, $sql);
         $row = mysqli_fetch_array($query);
         $id_access = $row['id_access'];
         $date = $row['date'];
         if ($row > 0) {
           header("Location: insertdeserted.php?id_access=$id_access");
         }else{
             header("Location: insertarrival.php?id=$id");
         }

    }else{
      echo "Usuario Inactivo";
}
}else{
   echo "No esta en la base de datos";
}

?>

