<?php
require('../library/fpdf.php');

include '../../modelo/connection/connection2.php';
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../../vista/assets/images/logopage.jpg',80,0,45);
    // Arial bold 15
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(50);
    // Title
    //$this->Cell(100,20,'Lista De Usuarios Registrados',0,0,'C');
    $this->Cell(70,60,'Lista De Usuarios Registrados ',0,2,'C');
    $this->Cell(70,-40,'Sistema De Acceso CEET',0,0, 'C');

    // Line break
    $this->Ln(0);
}

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
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(180,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}
$consult = "SELECT user.id, name, last_name, email, name_type, state FROM user INNER JOIN user_type ON user.id_type=user_type.id_type WHERE name_type NOT IN ('admin', 'operador')";
$result = mysqli_query($conn, $consult);

$html='En el siguiente documento se encuentran la lista de los usuarios registrados en el sistema de informacion (Sistema De Control De Acceso CEET), cada usuario esta identificado con un numero individual, un tipo de rol y un estado que muestra si esta activo o inactivo en los accesos a la sede.<br><br>';


$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->SetLeftMargin(18);
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
$pdf->WriteHTML($html);
 
// cabezales

$pdf->Cell(15,10, '#', 1, 0, 'C', 0);
$pdf->Cell(25,10, 'Nombre', 1, 0, 'C', 0);
$pdf->Cell(25,10, 'Apellido', 1, 0, 'C', 0);
$pdf->Cell(60,10, 'Email', 1, 0, 'C', 0);    
$pdf->Cell(25,10, 'Rol', 1, 0, 'C', 0);
$pdf->Cell(25,10, 'Estado', 1, 1, 'C', 0);


while($row = mysqli_fetch_assoc($result)){

// info

  $pdf->Cell(15,10, $row['id'], 1, 0, 'C', 0);
  $pdf->Cell(25,10, $row['name'], 1, 0, 'C', 0);
  $pdf->Cell(25,10, $row['last_name'], 1, 0, 'C', 0);
  $pdf->Cell(60,10, $row['email'], 1, 0, 'C', 0);
  $pdf->Cell(25,10, $row['name_type'], 1, 0, 'C', 0);
  $pdf->Cell(25,10, $row['state'], 1, 1, 'C', 0);
}

$pdf->Output();
?>
