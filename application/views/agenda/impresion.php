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
        global $prog;
        global $proy;
        global $ue;

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
$pdf = new MYPDF('R', PDF_UNIT, $custom_layout, true, 'UTF-8', false);
$titulo_reporte = 'Agenda de Medios';
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

/* $pdf->SetXY(15, 30);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('dejavusans', 'B', 9);
$pdf->Cell(0, 4, 'AGENDA MEDIOS', 0, 0, 'C', true); */

$pdf->SetXY(15, 36);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('dejavusans', '', 7);


$html = '<h1 align="center">AGENDA DE MEDIOS</h1>';
if($fecha_fin != '')
{
    $html .= '<h2 align="center">Del '.$fecha_ini.' al '.$fecha_fin.'</h2>';
    $nombre = "AgendaMedios_".$fecha_ini.'-'.$fecha_fin;
}
else{
    $html .= '<h2 align="center">'.$fecha_ini.'</h2>';
    $nombre = "AgendaMedios_".$fecha_ini;
}
$identificador = "";
foreach ($agenda as $value) {

    
    if($identificador !=  $value->id_espacio)
    {
        $html .= '<div border="2"><table rules="none" cellpadding="3" border="0.5"><tr><td align="center" colspan="5" bgcolor="#000000" color="#FFFFFF"><font size="8"><b>'.$value->motivo_espacio.'</b></font></td></tr>
        <tr><td colspan="5" align="center"><b>INTERLOCUTOR: '.$value->nombre_completo.'</b></td></tr>
        <tr><td colspan="1" align="center"><b>Fecha y Hora</b></td><td colspan="2" align="center"><b>Medio</b></td><td colspan="1" align="center"><b>Programa</b></td><td colspan="1" align="center"><b>Observación</b></td></tr>';
        
        $where = "agenda.id_estado = 1";

        $hoy = date('Y-m-d');

        if ($fecha_ini != '' && $fecha_fin != '') {
            $where .= " AND agenda.fecha BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_fin . " 23:59'";
        } else {
            if ($fecha_ini != '') {
                $where .= " AND agenda.fecha BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_ini . " 23:59'";
            } else {
                $where .= " AND agenda.fecha BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";
            }
        }

        $where .= 'AND agenda.id_espacio = '.$value->id_espacio;

        $this->db->join('programa', 'agenda.id_programa  = programa.id_programa', 'left');
        $this->db->join('recurso', 'recurso.id_recurso = programa.id_recurso', 'left');
        $agenda = $this->main->getListSelect('agenda', "concat( to_char(agenda.fecha,'DD/MM/YYYY'),' ',to_char(agenda.hora,'HH24:MI'))as fecha_hora, recurso.nombre, agenda.lugar, programa.nombre_programa, agenda.fecha, agenda.hora, agenda.asistio", ['agenda.fecha' => 'ASC', 'agenda.hora' => 'ASC'], $where);

        foreach ($agenda as $valor) {

            if($valor->asistio == null)
            {
                $asistio = "";
            }
            else{
                $asistio = $valor->asistio;
            }
            $html .= '<tr><td colspan="1" align="center">'.$valor->fecha_hora.'</td><td colspan="2" align="center">'.$valor->nombre.' - '.$valor->lugar.'</td><td colspan="1" align="center">'.$valor->nombre_programa.'</td><td colspan="1" align="center">'.$asistio.'</td></tr>';        
        }
        $html .= '</table><br><br><br><br><br>';
    }

    $identificador = $value->id_espacio;
}

$pdf->writeHTML($html, true, true, true, true, '');
$pdf->Output($nombre.'pdf', 'D');
