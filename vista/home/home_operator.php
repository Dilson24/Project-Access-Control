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
        header("Location: ../../index.html");
  }
?>
    <link rel="stylesheet" href="../../vista/css/index/style_forms.css">
    <nav class="menu" id="menu">
        <span><a href="#home" class="user"><?=  $data1, ' ',$data2 ?></a></span>
        <ul class="list">
            <li><a href="#section1">Escanear Codigo</a></li>
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
               <h2 class="subtitle sub2">Información General</h2>
                <p class="knowledge__paragraph">¡Bienvenido! Como operador, tus actividades consistirán en realizar el escaneo de los códigos de acceso que cada usuario tiene y previamente generaron en sus perfiles personales, ahora lo unico que debes hacer es bajar a la sección de recepción de código donde deberas activar la camara de tu dispositivo que servira para leer los códigos, validarlos y almacenarlos en la base de datos.</p>
            </div>
            <figure class="knowledge__picture">
                <img src="../assets/images/operador.svg" alt="" class="knowledge__img">
            </figure>
        </div>
    </section>

<section id="section1" class="container about">
        <h2 class="subtitle add">Escanear Código</h2>
           <video id="preview" style="margin-top: 50px;">
           <div class="info"></div></video><br>
        <form action="../../modelo/actions/login.php" method="post">
        <input type="text" name="text" id="text" style="display:none;">
        </form>

    <script>
        let scanner = new Instascan.Scanner({ video:document.getElementById('preview')});
        Instascan.Camera.getCameras().then(function(cameras){
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            }else{
                alert('sin camera');
            }
        }).catch(function(e){
            console.error(e);
        });

        scanner.addListener('scan',function(c){
        document.getElementById('text').value = c;
        document.forms[0].submit();

        });
    </script>


</section>
<script type="text/javascript" src="../../controlador/js/dinamic_styles.js"></script>
  <?php include '../../vista/includes/footer_home.php'; ?>
