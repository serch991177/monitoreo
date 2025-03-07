<?php
//content="text/plain; charset=utf-8"
require_once ('node_modules/jpgraph-4.3.5/src/jpgraph.php');
require_once ('node_modules/jpgraph-4.3.5/src/jpgraph_bar.php');
require_once ('node_modules/jpgraph-4.3.5/src/jpgraph_pie.php');
/**
 * Created by PhpStorm.
 *
 * Date: 23-12-19
 * Time: 02:34 PM
 */
//global $footer_codigo;
global $footer_fecha;
global $footer_editable;
$footer_fecha = date('d/m/Y');

class MYPDF extends TCPDF
{
    public function Header()
    {
      global $footer_fecha;
      global $footer_editable;

      $this->SetY(12);
      $this->SetFont('dejavusans', 'B', 10);
      $this->Image(K_PATH_IMAGES . 'firma_GAMC.png', 10, 4, 98, 32, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
      $this->Cell(20, 5, '');
      $this->SetFont('dejavusans', 'B', 9);
      $this->SetXY(105, 12);
      $this->Cell(0, 7, 'GOBIERNO AUTÓNOMO MUNICIPAL DE COCHABAMBA', 0, 1);
      $this->SetFont('dejavusans', 'B', 9);
      $this->Cell(105, 5);
      $this->Cell(0, 7, 'UNIDAD DE MONITOREO', 0, 1);


    }
    // Page footer
    /*public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('dejavusans', 'I', 8);
        // Page number
        $style = array('width' => 0.5, 'color' => array(0, 0, 0), 'cap' => 'butt');
        //$this->Line(16, 190, 280, 190, $style);
        $this->Cell(0, 2, 'GOBIERNO AUTÓNOMO MUNICIPAL DE COCHABAMBA', 0, 1);
        $this->Cell(0, 3, 'Plaza 14 de Septiembre Nº210 esquina General Achá', 0, 1);
        $this->Cell(0, 4, 'Telf.: 4258030', 0, 1);
        $this->Cell(0, 5, 'www.cochabamba.bo', 0, 1);
        //$this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }*/
}

// create new PDF document
$pdf = new MYPDF('R', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$sep_fech = explode('-',$fecha_i);
if($sep_fech[1]== '01'){
  $mes ='Enero';
}
else if($sep_fech[1]== '02'){
  $mes ='Febrero';
}
else if($sep_fech[1]== '03'){
  $mes ='Marzo';
}
else if($sep_fech[1]== '04'){
  $mes ='Abril';
}
else if($sep_fech[1]== '06'){
  $mes ='Junio';
}
else if($sep_fech[1]== '07'){
  $mes ='Julio';
}
else if($sep_fech[1]== '08'){
  $mes ='Agosto';
}
else if($sep_fech[1]== '09'){
  $mes ='Septiembre';
}
else if($sep_fech[1]== '10'){
  $mes ='Octubre';
}
else if($sep_fech[1]== '11'){
  $mes ='Noviembre';
}
else if($sep_fech[1]== '12'){
  $mes ='Diciembre';
}

if($fecha_i == $fecha_f){
  $titulo_reporte = 'Reporte Funcionario de fecha '.$sep_fech[2]. ' de '.$mes.' del '.$sep_fech[0] ;
}
else{
  $titulo_reporte = 'Reporte Funcionario de fecha'.$fecha_i.' al '.$fecha_f  ;
}



// set document information
$pdf->SetTitle($titulo_reporte);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $titulo_reporte, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetMargins(4, PDF_MARGIN_TOP, 4);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 16);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// dejavusans or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();
$pdf->AddPage('L');
$style = array('width' => 0.5, 'color' => array(0, 0, 0), 'cap' => 'butt');
$style = array('width' => 0.5, 'color' => array(0, 0, 0), 'cap' => 'butt');
$pdf->SetFont('dejavusans', 'B', 8, '', true);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $titulo_reporte, PDF_HEADER_STRING, array(0, 40, 255), array(0, 40, 128));
$pdf->SetFont('dejavusans', '',9, '', true);
//$wAsist = (55 / $totalAsist);
$html = '';
//$not = preg_replace( "/\([^)]+\)/","",$notas_t);


$tabla = $this->load->view('normal/reporte/vista_fun','', TRUE);

$pdf->writeHTML($tabla, true, true, true, true, '');

$conta_fun = explode(',', $cont_f);
$funcionarios= explode(',', $funcionarios_array);


$data1y=$conta_fun;


$html='';
$pdf->AddPage('L');

$pdf->SetFont('dejavusans', '', 7, '', true);
$tabla = $this->load->view('normal/reporte/func','', TRUE);

$pdf->writeHTML($tabla, true, true, true, true, '');

$cont_funci = explode(',',$cont_fu);
$dat = implode('-',$cont_funci);


//$html .= '<p>'.$dat.'</p>';
//$ruta = "http://192.168.104.44/monitoreo.cochabamba.bo/torta-fun/".$dat;
$ruta = "https://monitoreo.cochabamba.bo/torta-fun/".$dat;
$html .= '<img src="'.$ruta.'" width="550px" height="380px" />';

$pdf->writeHTML($html, true, true, true, true, '');


//$pdf->writeHTML($html, true, true, true, true, '');
if($fecha_i == $fecha_f){
  $pdf->Output('reporteFuncionario'.$fecha_i . '.pdf', 'I');
}
else{
  $pdf->Output('reporteFuncionario'.$fecha_i.'al'.$fecha_f . '.pdf', 'I');
}


/*
echo '<pre>';
print_r($html);
echo '</pre>';
die();*/
// ---------------------------------------------------------¡
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
//============================================================+
// END OF FILE
//============================================================+
