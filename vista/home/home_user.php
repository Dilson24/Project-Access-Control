<?php

include '../../modelo/connection/connection.php';
include '../../vista/includes/header_home.php';

session_start();
  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT name, last_name, email FROM user WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
      $data1 = $user['name'];
      $data2 = $user['last_name'];
      $data3 = $user['email'];
    }
  }else{
        header("Location: ../index.html");
  }
?>
    <nav class="menu" id="menu">
        <span><a href="#home" class="user"><?=  $data1, ' ',$data2 ?></a></span>
        <ul class="list">
            <li><a href="#section1">Ver Registros</a></li>
            <li><a href="#section2">Generar Codigo</a></li>
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
                <h2 class="subtitle sub2">Ver Registros</h2>
                <p class="knowledge__paragraph">Perfil personal, en este aplicativo web usted podra visualizar los accesos de llegada y salida a la institución por medio del uso de un código QR que podrá generar aqui mismo, el código de acceso es unico y personal, en el momento de acceder a la institución el operador escaneará el codigo y dependiendo su estado, (Activo o Inactivo).</p>
            </div>
            <figure class="knowledge__picture">
                <img src="../assets/images/profiledraw3.svg" alt="" class="knowledge__img">
            </figure>
        </div>
    </section>

    <section id="section1" class="container about">
        <h2 class="subtitle">Mis Accesos A La Institución</h2>

<table class="customTable" >
<thead class="principal">
		<tr>
            <th>Codigo De Registro</th>
            <th>Hora De Entrada</th>
			<th>Hora De Salida</th>
            <th>Fecha</th>
		</tr>
</thead>
		<?php
        include '../../modelo/connection/connection2.php';

        $sql="SELECT id_access, access.id_user, arrival, deserted, date FROM user INNER JOIN access ON user.id=access.id_user WHERE email = '$data3' ORDER BY date";
		$result=mysqli_query($conn, $sql);
        $validate = false;
		while($mostrar=mysqli_fetch_array($result)){
            $validate = true;
        ?>
		<tr>
            <td class="rows" ><?php echo $mostrar['id_access'] ?></td>
            <td class="rows" ><?php echo $mostrar['arrival'] ?></td>
			<td class="rows" ><?php echo $mostrar['deserted'] ?></td>
			<td class="rows" ><?php echo $mostrar['date'] ?></td>
		</tr>
	<?php
	}
	 ?>
	</table>

    <?php if($validate) { ?>
        <div class="download"><a href="../../controlador/reports/reports_user_records.php" target="_BLANK">Descargar Registros</a></div>
    <?php }else{ ?>
        <div class="download"><a href="#">Sin Registros Aun!</a></div>
    <?php }?>

</section>

<section class="knowledge info new" id="section2">

<style>
.new{
    width: 100%;
    border-radius:0;
    background-image:0;
}
.cta{
    margin-top: 20px;
}

</style>

        <div class="knowledge__container container">
            <div class="knowledge__texts">
                <h2 class="subtitle sub2">Generar Código</h2>
                <p class="knowledge__paragraph">Genere en este apartado su código QR, el cual le permitirá el acceso al CEET almacenando su registro de ingresos y egresos de forma controlada y segura, este paso es indispensable de realizar ya que sin este no se le permitirá el acceso a las instalaciones.</p>

<?php

    include '../../modelo/connection/connection.php';
    include('../../controlador/library/phpqrcode/lib/full/qrlib.php');

    if (isset($_SESSION['user_id'])) {
      $records = $conn->prepare('SELECT id, email, name, last_name FROM user WHERE id = :id');
      $records->bindParam(':id', $_SESSION['user_id']);
      $records->execute();
      $results = $records->fetch(PDO::FETCH_ASSOC);
      $user = null;
  
      if(count($results) > 0 ) {
        $user = $results;
        $data1 = $user['id'];
        $data2 = $user['email'];
        $data3 = $user['name'];
        $data4 = $user['last_name'];

            $codesDir = "../../controlador/codeqr/codes/".$data3."-".$data4."-".$data1."/";
            $codeFile = $data1.'.png';
            if (!file_exists($codesDir)) {
            mkdir("../../controlador/codeqr/codes/".$data3."-".$data4."-".$data1, 0777);
            $download = "../../controlador/codeqr/codes/".$data3."-".$data4."-".$data1."/".$data1.'.png';
            QRcode::png($data2, $codesDir.$codeFile, $ecc='H', $size=10);
            }else{
            $download = "../../controlador/codeqr/codes/".$data3."-".$data4."-".$data1."/".$data1.'.png';
            }
      }
    }
?>

           <a class="cta" style="cursor:pointer" onclick="change();" id="botton">Mostrar Código </a>
            </div>
            <figure class="knowledge__picture">
                <img src="../assets/images/qr.svg" class="knowledge__img" id="photo" >
                <script>

                    function change(){
                        let a = document.getElementById("botton");
                        a.onclick = download; 
                        var newphoto = document.getElementById("photo");
                        newphoto.src = "<?= $download ?>";
                        document.getElementById("botton").innerHTML="Descargar Código";
                    }
                    function download() {
                        document.getElementById("botton").href="<?= $download ?>";
                        document.getElementById("botton").setAttribute("download", "");
                    }
                </script>
            </figure>
        </div>
    </section>

<?php include '../../vista/includes/footer_home.php'; ?>

