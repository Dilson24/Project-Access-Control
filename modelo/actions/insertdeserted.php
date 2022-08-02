<?php
include ("../connection/connection2.php");
$id_access = $_GET['id_access'];
  $insert = "UPDATE access SET deserted = CURTIME() WHERE id_access= '$id_access'";
  $query = mysqli_query($conn, $insert);
  if ($query) {
  echo "<script> alert ('Salida Autorizada'); window.location='../../vista/home/home_operator.php'</script>";
  }else{
  echo "<script> alert ('Salida No Autorizada'); window.location='../../vista/home/home_operator.php'</script>";
  }
  ?>
