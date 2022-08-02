<?php
include ("../connection/connection2.php");
$id= $_GET['id'];
$insert = "INSERT INTO access (arrival, date, id_user) VALUES (CURTIME(), CURDATE(), '$id')";
$query = mysqli_query($conn, $insert);
  if ($query) {
  echo "<script> alert ('Entrada Autorizada'); window.location='../../vista/home/home_operator.php'</script>";
  }else{
  echo "<script> alert ('Entrada No Autorizada'); window.location='../../vista/home/home_operator.php'</script>";
  }

?>

