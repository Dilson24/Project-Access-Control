<?php

include '../../modelo/connection/connection.php';
include '../../vista/includes/header_home.php';



session_start();
  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT name, last_name FROM user WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $user = null;
    if (count($results) > 0) {
      $user = $results;
      $data1 = $user['name'];
      $data2 = $user['last_name'];
    }
  }else{
        header("Location: ../index.html");
        
  }
?>
    <nav class="menu" id="menu">
        <span><a href="#home" class="user"><?=  $data1, ' ',$data2 ?></a></span>
        <ul class="list">
            <li><a href="#section1">Ver Usuarios</a></li>
            <li><a href="#section2">Ver Reportes</a></li>
            <li><a href="../../modelo/forms/signup.php">Registrar usuario</a><li>
            <li><a href="../../modelo/forms/logout.php">Cerrar Sesion</a></li>
        </ul>
    </nav>
    <div class="content_icons" id="content_icons">
        <div class="icon_close icon_none btn" id="close">
            <img src="../assets/icons/menublack.svg" name="close-outline" alt="">
        </div>
        <div class="icon_multi btn" id="multi">
            <img src="../assets/icons/menublack.svg" name="grid-outline" alt="">
        </div>
    </div>




    <section class="knowledge info" id="home" style="width: 100%; border-radius: 0px;">
        <div class="knowledge__container container">
            <div class="knowledge__texts">
                <h2 class="subtitle sub2">Personas y Registros</h2>
                <p class="knowledge__paragraph">En la siguientes tablas se observan los usuarios que se han registrado en el sistema de acceso, así como tambien las persona que a la cuales se les ha generado algún registro por ingreso o salida de la institución CEET. </p>
            </div>
            <figure class="knowledge__picture">
                <img src="../assets/images/profile.svg" alt="" class="knowledge__img">
            </figure>
        </div>
    </section>


<section id="section1" class="container about">
        <h2 class="subtitle add">Usuarios Registrados</h2>


<table class="customTable" >
    <form action="../../modelo/actions/update_user.php" method="POST">
<thead class="principal">
		<tr>
            <th>Identificación</th>
            <th>Nombre</th>
	        <th>Apellido</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Operaciones</th>
		</tr>
</thead>
		<?php
        include '../../modelo/connection/connection2.php';
		$sql="SELECT user.id, name, last_name, email, name_type, state FROM user INNER JOIN user_type ON user.id_type=user_type.id_type WHERE name_type NOT IN ('admin', 'operador') ORDER BY state,user.id ";
		$result=mysqli_query($conn, $sql);
		while($mostrar=mysqli_fetch_array($result)){
		 ?>

		<tr>
            <td class="rows" ><?php echo $mostrar['id'] ?></td>
            <td class="rows" ><?php echo $mostrar['name'] ?></td>
            <td class="rows" ><?php echo $mostrar['last_name'] ?></td>
            <td class="rows" ><?php echo $mostrar['email'] ?></td>
            <td class="rows" ><?php echo $mostrar['name_type'] ?></td>
            <td class="rows" >

            <?php if($mostrar['state'] === 'Activo'){ ?>
                    <img src="../assets/icons/check.svg" alt="" class="about__icon">
            <?php }else{ ?>
                    <img src="../assets/icons/uncheck.svg" alt="" class="about__icon"> 
            <?php } ?>
        </td>

            <td class="rows">
<style>
    .about__icon{
        width: 33px;
        margin:auto;
        margin-right:20px;
        margin-left:20px;
    }
    .about__icon2{
        width:27px;
    }



</style>
               <a href="../../modelo/actions/update_user.php?id=<?php echo $mostrar['id'] ?>">
                    <img src="../assets/icons/update.svg" alt="" class="about__icon"></a> 
                <a href="../../modelo/actions/delete_user.php?id=<?php echo $mostrar['id'] ?>">
                    <img src="../assets/icons/delete.svg" alt="" class="about__icon2"></a>
            </td>                    
        </tr>
        <?php } ?>
    </form>
</table>


<div class="download"><a href="../../controlador/reports/reports_admin_users.php" target="_BLANK">Descargar Lista De Usuarios</a></div>

</section>

 <section id="section2" class="container about second_about ">
        <h2 class="subtitle add">Registros De Ingresos</h2>


<table class="customTable" >
<thead class="principal">
		<tr>
            <th>Codigo De Registro</th>
			<th>Usuario </th>
            <th>Hora De Llegada</th>
            <th>Hora De Salida</th>
            <th>Fecha</th>
		</tr>
</thead>
		<?php
		$sql="SELECT id_access, user.id, name_type, arrival, deserted, date FROM access INNER JOIN user ON access.id_user=user.id INNER JOIN user_type ON user.id_type=user_type.id_type WHERE name_type NOT IN ('admin') ORDER BY id_access";
		$result=mysqli_query($conn,$sql);
		while($mostrar=mysqli_fetch_array($result)){
		 ?>

		<tr>
            <td class="rows" ><?php echo $mostrar['id_access'] ?></td>
			<td class="rows" ><?php echo $mostrar['id'] ?></td>
			<td class="rows" ><?php echo $mostrar['arrival'] ?></td>
			<td class="rows" ><?php echo $mostrar['deserted'] ?></td>
			<td class="rows" ><?php echo $mostrar['date'] ?></td>

		</tr>
	<?php
	}
	 ?>
	</table>
<div class="download"><a href="../../controlador/reports/reports_admin_records.php" target="_BLANK">Descargar Registros</a></div>

</section>

<?php include '../../vista/includes/footer_home.php'; ?>
