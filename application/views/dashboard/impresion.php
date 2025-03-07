<?php

/**
 * Created by PhpStorm.
 *
 * Date: 23-12-19
 * Time: 02:34 PM
 */
/* global $prog;
global $proy;
global $ue;

$prog = $programa;
$proy = $proyecto;
$ue = $unidad_ejecutora; */

class MYPDF extends TCPDF
{
    public function Header()
    {

        $style = array('width' => 0.2, 'color' => array(0, 0, 0), 'cap' => 'butt');
    }
    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font    
        $this->SetFont('dejavusans', '', 6, '', true);
        $this->Cell(0, 10, 'Pagina ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$custom_layout = array(216, 279);
$pdf = new MYPDF('L', PDF_UNIT, $custom_layout, true, 'UTF-8', false);
$titulo_reporte = 'Seguimiento de Notas';
// set document information
$pdf->SetTitle($titulo_reporte);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $titulo_reporte, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
//$pdf->SetMargins(4, PDF_MARGIN_TOP, 4);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);

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

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

$pdf->SetFont('dejavusans', 'B', 8, '', true);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $titulo_reporte, PDF_HEADER_STRING, array(0, 40, 255), array(0, 40, 128));

$style = array('width' => 0.2, 'color' => array(0, 0, 0), 'cap' => 'butt');

$pdf->SetY(12);
$pdf->Image(K_PATH_IMAGES . 'escudo.png', 18, 10, 15, 17, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
$pdf->SetFont('dejavusans', 'B', 9);
$pdf->SetXY(35, 10);
$pdf->Cell(0, 12, 'GOBIERNO AUTÓNOMO MUNICIPAL DE COCHABAMBA', 0, 0, 'L');
$pdf->SetXY(35, 14);
$pdf->Cell(0, 12, 'DIRECCIÓN DE PRENSA E IMAGEN CORPORATIVA', 0, 0, 'L');
$pdf->SetXY(35, 18);
$pdf->Cell(0, 12, 'UNIDAD DE MONITOREO INFORMATIVO', 0, 0, 'L');

$pdf->SetXY(15, 30);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('dejavusans', 'B', 9);
$pdf->Cell(0, 4, $tema, 0, 0, 'C', true);

$pdf->SetXY(15, 36);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('dejavusans', '', 7);


$html = '';

$html .= '<table rules="none" cellpadding="1" cellspacing="0" >
            <tr><td colspan="1" align="center"><font size="7"><b>Nº</b></font></td><td colspan="2" align="center"><font size="7"><b>MEDIO</b></font></td><td colspan="1" align="center"><font size="7"><b>TENDEN.</b></font></td><td colspan="2" align="center"><font size="7"><b>DEPENDENCIA</b></font></td><td colspan="2" align="center"><font size="7"><b>TIPO NOTICIA</b></font></td><td colspan="1" align="center"><font size="7"><b>TURNO</b></font></td><td colspan="2" align="center"><font size="7"><b>FECHA</b></font></td><td colspan="5" align="center"><font size="7"><b>DETALLE</b></font></td></tr>';

foreach ($notas as &$nota) {

    $html .= '<tr><td colspan="1">'.$nota->row.'</td><td colspan="2">'.$nota->nombre.'</td><td colspan="1">'.$nota->nombre_tendencia.'</td><td colspan="2">'.$nota->nombre_dependencia.'</td><td colspan="2">'.$nota->tipo_noticia.'</td><td colspan="1">'.$nota->turno.'</td><td colspan="2">'.$nota->fecha_registro_nota.'</td><td colspan="5">'.html_entity_decode($nota->detalle).'</td></tr>';    
}


$html .= '</table>';

$pdf->writeHTML($html, true, true, true, true, '');
$pdf->Output('Notas' . date('dmY') . '.pdf', 'D');
