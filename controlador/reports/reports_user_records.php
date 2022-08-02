<?php

require('../library/fpdf.php');
include '../../modelo/connection/connection2.php';

class PDF extends FPDF
{
// Page header
function Header()
{
    $this->Image('../../vista/assets/images/logopage.jpg',80,0,45);
    $this->SetFont('Arial','B',13);
    $this->Cell(50);
    $this->Cell(90,60,utf8_decode('Accesos Realizados En La Institución') ,0,2,'C');
    $this->Cell(90,-40,'Sistema De Acceso CEET',0,0, 'C');
    $this->Ln(0);

    // $this->Cell(55,10,utf8_decode('Código De Registro'), 1, 0, 'C', 0);
    // $this->Cell(50,10, 'Hora De Llegada', 1, 0, 'C', 0);
    // $this->Cell(50,10, 'Hora De Salida', 1, 0, 'C', 0);
    // $this->Cell(35,10, 'Fecha', 1, 1, 'C', 0);
}

        //Función si se quiere escribir un texto || Colocar variable $html
        function WriteHTML($html){
            
          // HTML parser || Analizador de HTML
          $html = str_replace("\n",' ',$html);
          $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
          foreach($a as $i=>$e){
              if($i%2==0){
                      $this->Write(6,$e);
              }
              else{
                  if($e[0]=='/')
                      $this->CloseTag(strtoupper(substr($e,1)));
                  else{
                      $a2 = explode(' ',$e);
                      $tag = strtoupper(array_shift($a2));
                      $attr = array();
                      foreach($a2 as $v){
                          if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                              $attr[strtoupper($a3[1])] = $a3[2];
                      }
                      $this->OpenTag($tag,$attr);
                  }
              }
          }
      }
      
      //No sé qué hace esta función :c
      function OpenTag($tag, $attr) {
          if($tag=='BR') {
              $this->Ln(8);
          }
      }

      function CloseTag($tag) {
          // Etiqueta de cierre
          if($tag=='B' || $tag=='I' || $tag=='U')
              $this->SetStyle($tag,false);
          if($tag=='A')
              $this->HREF = '';
      }

      function SetStyle($tag, $enable) {
          // Modificar estilo y escoger la fuente correspondiente
          $this->$tag += ($enable ? 1 : -1);
          $style = '';
          foreach(array('B', 'I', 'U') as $s)
          {
              if($this->$s>0)
                  $style .= $s;
          }
          $this->SetFont('',$style);
      }

      function PutLink($URL, $txt) {
          // Escribir un hiper-enlace
          $this->SetTextColor(0,0,255);
          $this->SetStyle('U',true);
          $this->Write(5,$txt,$URL);
          $this->SetStyle('U',false);
          $this->SetTextColor(0);
      }


function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(90,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}

session_start();
$id  = $_SESSION['user_id'];
$consult = "SELECT * FROM user WHERE id = '$id'";
$result = mysqli_query($conn, $consult);
$row = mysqli_fetch_array($result);

$html='En el siguiente documento se encuentran los registros de acceso del aprendiz ' . $row['name'] . ' ' . $row['last_name'] .',        identificada con el numero de idenficacion '.$id.' de ciudadania. En la tabla estan las horas de entrada y salida que hizo el aprendiz en la sede Centro De Electricidad, Electronica Y Telecomunicaciones con sede en Bogota D.C, esto a traves del uso del codigo QR que cada aprendiz genera en el sistema web. Dentro de la tabla cada registro tiene un codigo de identificacion propia (Codigo de registro) y tambien la fecha en que se almacenaron los registros.<br><br>';

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->SetLeftMargin(10);
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->WriteHTML($html);

$pdf->Cell(55,10,utf8_decode('Código De Registro'), 1, 0, 'C', 0);
$pdf->Cell(50,10, 'Hora De Llegada', 1, 0, 'C', 0);
$pdf->Cell(50,10, 'Hora De Salida', 1, 0, 'C', 0);
$pdf->Cell(35,10, 'Fecha', 1, 1, 'C', 0);

$consult2 = "SELECT name, last_name, user.id, id_access, arrival, deserted, date FROM access INNER JOIN user ON user.id=access.id_user WHERE id_user = '$id'";
$result2 = mysqli_query($conn, $consult2);

while($row2 = mysqli_fetch_assoc($result2)){

  $pdf->Cell(55,10, $row2['id_access'], 1, 0, 'C', 0);
  $pdf->Cell(50,10, $row2['arrival'], 1, 0, 'C', 0);
  $pdf->Cell(50,10, $row2['deserted'], 1, 0, 'C', 0);
  $pdf->Cell(35,10, $row2['date'], 1, 1, 'C', 0);
}

$pdf->Output();
?>
