<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('node_modules/jpgraph-4.3.5/src/jpgraph.php');
require_once ('node_modules/jpgraph-4.3.5/src/jpgraph_bar.php');
require_once ('node_modules/jpgraph-4.3.5/src/jpgraph_pie.php');


class Pdf extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

   public function __construct()
   {

   }


   public function ejemplo($data)
 	{
    $datos = explode('-',$data);
    /*print_r($datos);
      die();*/

 		//$data = array(40,21,17,14,23);
  /*  print_r($dataly);
    die();*/
 		// Create the Pie Graph.
 		$graph = new PieGraph(350,250);

 		$theme_class="DefaultTheme";
 		//$graph->SetTheme(new $theme_class());

 		// Set A title for the plot
 		//$graph->title->Set("A Simple Pie Plot");
 		$graph->SetBox(true);

 		// Create
 		$p1 = new PiePlot($datos);
 		$graph->Add($p1);

 		$p1->ShowBorder();
 		$p1->SetColor('black');
 		$p1->SetSliceColors(array("#4AC1E0", "#6D56A0", "#EA547C", "#4FB9A8", "#F9B154", "#009877", "#00ACD8", "#482778", "#AE1857", "#F18721"));
 		$graph->Stroke();
  /*  $lineplot->SetLegend ("Plot 1");
    $lineplot2 ->SetLegend("Plot 2");
     $graph ->legend->Pos( 0.05,0.5,"right" ,"center");*/

 	}


  public function funcionario($data)
 {
   $datos = explode('-',$data);

   $graph = new PieGraph(350,250);

   $theme_class="DefaultTheme";
   //$graph->SetTheme(new $theme_class());

   // Set A title for the plot
   //$graph->title->Set("A Simple Pie Plot");
   $graph->SetBox(true);

   // Create
   $p1 = new PiePlot($datos);
   $graph->Add($p1);
//$graph->legend->Show();

   $p1->ShowBorder();
   $p1->SetColor('black');
   $p1->SetSliceColors(array("#4AC1E0", "#6D56A0", "#EA547C", "#4FB9A8", "#F9B154", "#009877", "#00ACD8", "#482778", "#AE1857", "#F18721"));
   $graph->Stroke();
 /*  $lineplot->SetLegend ("Plot 1");
   $lineplot2 ->SetLegend("Plot 2");
    $graph ->legend->Pos( 0.05,0.5,"right" ,"center");*/

 }
public function barras(){

  //$datos = explode('-',$data);
  $datay=array(62,105,85,50);


// Create the graph. These two calls are always required
$graph = new Graph(350,220,'auto');
$graph->SetScale("textlin");

//$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());

// set major and minor tick positions manually
$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
$graph->SetBox(false);

//$graph->ygrid->SetColor('gray');
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('A','B','C','D'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($datay);

// ...and add it to the graPH
$graph->Add($b1plot);


$b1plot->SetColor("white");
$b1plot->SetFillGradient("#4B0082","white",GRAD_LEFT_REFLECTION);
$b1plot->SetWidth(45);
$graph->title->Set("Bar Gradient(Left reflection)");

// Display the graph
$graph->Stroke();
}


}
