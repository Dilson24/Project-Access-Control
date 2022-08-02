<?php

include '../connection/connection2.php';

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query2 = "SELECT name, last_name FROM user WHERE id ='$id'";
     $result2 = mysqli_query($conn, $query2);
     $row = mysqli_fetch_array($result2);

    $query = "DELETE FROM user WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if (!$result) {
      die("Eliminación Fallida");

    }


  function deleteDirectory($dir) {
    if(!$dh = @opendir($dir)) return;
    while (false !== ($current = readdir($dh))) {
        if($current != '.' && $current != '..') {
            echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
            if (!@unlink($dir.'/'.$current)) 
                deleteDirectory($dir.'/'.$current);
        }       
    }
    closedir($dh);
    echo 'Se ha borrado el directorio '.$dir.'<br/>';
    @rmdir($dir);
}
deleteDirectory("../../controlador/codeqr/codes/".$row['name']."-".$row['last_name']."-".$id);

    header("Location: ../../vista/home/home_admin.php");
    
  }

?>
