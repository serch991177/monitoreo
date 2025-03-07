<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('node_modules/jpgraph-4.3.5/src/jpgraph.php');
require_once('node_modules/jpgraph-4.3.5/src/jpgraph_bar.php');
require_once('node_modules/jpgraph-4.3.5/src/jpgraph_pie.php');

class Reporte extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    mb_internal_encoding("UTF-8");
    if (!isset($this->session->sistema)) {
      redirect(site_url());
    }
  }
  public function general()
  {
    /*print($this->session->sistema->id_rol);
      die();*/
    $estado = $this->main->getListSelect('estado', 'id_estado,descripcion', ['descripcion' => 'ASC']);
    $data['estados'] = $this->main->dropdown($estado, 'SELECCIONAR');
    $dependencias = $this->main->getListSelect('dependencia', 'id_dependencia,nombre_dependencia', ['nombre_dependencia' => 'ASC']);
    $data['dependencias'] = $this->main->dropdown($dependencias, 'SELECCIONAR');
    $medios = $this->main->getListSelect('recurso', 'id_recurso,nombre', ['nombre' => 'ASC']);
    $data['medios'] = $this->main->dropdown($medios, 'SELECCIONAR');
    $areas = $this->main->getListSelect('area', 'id_area,nombre_area', ['nombre_area' => 'ASC']);
    $data['areas'] = $this->main->dropdown($areas, 'SELECCIONAR');
    $tendencia = $this->main->getListSelect('tendencia', 'id_tendencia,nombre_tendencia', ['nombre_tendencia' => 'ASC']);
    $data['tendencias'] = $this->main->dropdown($tendencia, 'SELECCIONAR');

    //$this->db->join('recurso', 'nota.id_recurso = recurso.id_recurso', 'left');
    //  $this->db->join('tendencia', 'nota.id_tendencia = tendencia.id_tendencia', 'left');
    $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
    $this->db->join('area', 'area.id_area = nota.id_area', 'left');
    $this->db->join('dependencia', 'dependencia.id_dependencia = nota.id_dependencia', 'left');;
    $this->db->join('estado', 'estado.id_estado = nota.id_estado', 'left');
    $notas = $this->main->getListSelect('nota', "nota.id_nota, dependencia.nombre_dependencia, nota.detalle, nota.adjunto, area.nombre_area, estado.descripcion, nota.id_tema, tema.tema, area.id_area, dependencia.id_dependencia ", ["dependencia.nombre_dependencia" => 'ASC']);

    $data['notas'] = json_encode($notas);

    $this->load->view('normal/reporte/index', $data, FALSE);
  }
  public function index($search_custon = '', $draw = 1, $gestionSearch = '')
  {
    $start = $this->input->get('start');
    $draw = $this->input->get('draw');
    $length = $this->input->get('length');
    $search_value = $_GET['search']['value'];

    $columna = $_GET['order'][0]['column'];
    $dir = $_GET['order'][0]['dir'];

    if ($columna != '') {
      switch ($columna) {
        case '1':
          $orden['dependencia.nombre_dependencia'] = $dir;
          break;
        case '2':
          $orden['nota.tema'] = $dir;
          break;
        case '3':
          $orden['area.nombre_area'] = $dir;
          break;
        case '4':
          $orden['recurso.nombre'] = $dir;
          break;
        case '5':
          $orden['tendencia.nombre_tencencia'] = $dir;
          break;
        case '6':
          $orden['recurso.nombre'] = $dir;
          break;
        case '7':
          $orden['tendencia.nombre_tendencia'] = $dir;
          break;
        default:
          $orden['dependencia.nombre_dependencia'] = $dir;
          break;
      }
    } else {
      $orden['dependencia.nombre_dependencia'] = 'ASC';
    }

    $search_value = strtoupper($search_value);

    if ($search_value != '') {
      $this->db->like('dependencia.nombre_dependencia', $search_value, 'both', false);
      $this->db->or_like('nota.tema', $search_value, 'both', false);
      $this->db->or_like('estado.descripcion', $search_value, 'both', false);
    }

    $this->db->join('estado', 'nota.id_estado = estado.id_estado', 'left');
    $contador = $this->main->total('nota');

    if ($search_value != '') {

      $this->db->like('medio.nombre_medio', $search_value, 'both', false);
      $this->db->or_like('dependencia.detalle', $search_value, 'both', false);
      $this->db->or_like('estado.descripcion', $search_value, 'both', false);
    }
    $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
    $this->db->join('area', 'area.id_area = nota.id_area', 'left');
    $this->db->join('dependencia', 'dependencia.id_dependencia = nota.id_dependencia', 'left');;
    $this->db->join('estado', 'estado.id_estado = nota.id_estado', 'left');
    $notas = $this->main->getListSelect('nota', "nota.id_nota, dependencia.nombre_dependencia, nota.detalle, nota.adjunto, area.nombre_area, estado.descripcion, nota.id_tema, tema.tema, area.id_area, dependencia.id_dependencia ,to_char(nota.fecha_registro,'DD TMMonth YYYY') as fecha_registro_format,nota.fecha_registro", $orden, null, $length, $start);

    $data = $notas;

    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(
        json_encode([
          'draw' => $draw,
          'recordsTotal' => $contador,
          'recordsFiltered' => $contador,
          'data' => $data
        ])
      );
  }
  public function tematica()
  {
    $funcionarios = $this->main->getListSelect('usuario', 'usuario.id_usuario,persona.nombre_completo', ['persona.nombre_completo' => 'ASC'], ['usuario.id_rol' => 2], null, null, ['persona' => 'id_persona']);
    $data['funcionarios'] = $this->main->dropdown($funcionarios, 'TODOS LOS FUNCIONARIOS');

    $fecha_inicial = set_value('fecha_ini_submit');
    //$fecha_fin = set_value('fecha_fin_submit');
    $id_usu = set_value('funcionario');

    $id_usuario = $this->session->sistema->id_usuario;

    if(!isset($_POST['funcionario']))
    {
      $data['id_usuario'] = $id_usuario;  
    }
    else{
      if (empty($id_usu)) {
        $id_usuario = $this->session->sistema->id_usuario;
        $id_rol = $this->main->getField('usuario', 'id_rol', ['id_usuario' => $id_usuario]);
        if ($id_rol == 1) {
          $id_usuario = 0;  
        }

        $data['id_usuario'] = ""; 

      } else {
        $id_usuario = $id_usu;
        $data['id_usuario'] = $id_usuario; 
      }
      
    }

    //  if(isset($id_usu)){
    
    /*}
  else{
    $id_usuario = $this->session->sistema->id_usuario;
  }*/

    //print_r($id_usuario);
    $data['fecha_i'] = $fecha_inicial;
    //$data['fecha_f'] = $fecha_fin;
    



    if (empty($fecha_inicial)) {
      $fecha_i = date('Y-m-d');
      //$fecha_f = date('Y-m-d');
    } else {
      $fecha_i = $fecha_inicial;
      //$fecha_f = $fecha_fin;


    }

    if ($id_usuario > 0) {
      $data['lis_tendencias'] = $this->main->getListSelect('tendencia', 'id_tendencia,nombre_tendencia', ['nombre_tendencia' => 'ASC']);
      $query_i = "select nombre,count(detalle_medio.id_nota) as contador,t.tema
  		from detalle_medio
  		left join recurso on recurso.id_recurso = detalle_medio.id_recurso
  		left join nota  on nota.id_nota = detalle_medio.id_nota
  		 left join tema t on t.id_tema = nota.id_tema
  		where nota.id_estado=1 and
  		nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59' and detalle_medio.id_usuario = $id_usuario
  		group by nombre,t.tema";
    } else {
      $data['lis_tendencias'] = $this->main->getListSelect('tendencia', 'id_tendencia,nombre_tendencia', ['nombre_tendencia' => 'ASC']);
      $query_i = "select nombre,count(detalle_medio.id_nota) as contador,t.tema
  		from detalle_medio
  		left join recurso on recurso.id_recurso = detalle_medio.id_recurso
  		left join nota  on nota.id_nota = detalle_medio.id_nota
  		 left join tema t on t.id_tema = nota.id_tema
  		where nota.id_estado=1 and
  		nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59'
  		group by nombre,t.tema";
    }

    $consulta = $this->db->query($query_i);
    $data['listas_cont'] = $consulta->result();

    $where3['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where3['nota.fecha_registro <='] = $fecha_i . ' 23:59:59';
    $where3['nota.id_estado'] = 1;
    if ($id_usuario > 0) {
      $where3['detalle_medio.id_usuario'] = $id_usuario;
    }
    $tot = $this->main->total('detalle_medio', $where3, ['nota' => 'id_nota']);
    $data['tot'] = $tot;

    $select = 'nota.id_tema,tema.tema';
    $where['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where['nota.fecha_registro <='] = $fecha_i . ' 23:59:59';
    $where['nota.id_estado'] = 1;
    if ($id_usuario > 0) {
      $where['detalle_medio.id_usuario'] = $id_usuario;
    }
    $notasxtematica = $this->main->getListSelect('nota', $select, ['tema.tema' => 'ASC'], $where, null, null, ['tema' => 'id_tema','detalle_medio' => 'id_nota']);
    $data['temas'] = $notasxtematica;
    if ($id_usuario > 0) {
      $query_tem = "select tema.tema,count(detalle_medio.id_nota) as total
    from nota
    left join tema on nota.id_tema = tema.id_tema
    left join detalle_medio on nota.id_nota = detalle_medio.id_nota
    where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59' AND detalle_medio.id_usuario = $id_usuario
    group by tema.tema";
    } else {
      $query_tem = "select tema.tema,count(detalle_medio.id_nota) as total
   	from nota
   	left join tema on nota.id_tema = tema.id_tema
   	left join detalle_medio on nota.id_nota = detalle_medio.id_nota
   	where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59'
   	group by tema.tema";
    }
    $consulta = $this->db->query($query_tem);
    $cont_temas = $consulta->result();
    $conta_t = count($cont_temas);
    $i = 0;
    $tematicas = "[";
    $not = "[";
    foreach ($cont_temas as &$valor) {
      if ($i != $conta_t - 1) {
        $tematicas = $tematicas . '"' . $valor->tema . '",';

        $porcentaje = number_format(($valor->total * 100) / $tot, 2, ".", "");
        $not = $not . $porcentaje . ',';
      } else {
        $tematicas = $tematicas .  '"' . $valor->tema . '"]';
        $porcentaje = number_format(($valor->total * 100) / $tot, 2, ".", "");
        $not = $not . $porcentaje . ']';
      }
      $i++;
    }
    $data['tematicas'] = $tematicas;
    $data['not'] = $not;

    $select = 'recurso.id_recurso,recurso.nombre';

    $where2['recurso.id_estado'] = 1;
    $where2['detalle_medio.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where2['detalle_medio.fecha_registro <='] = $fecha_i . ' 23:59:59';
    if (!empty($id_usuario)) {
      $where2['detalle_medio.id_usuario'] = $id_usuario;
    }
    $medios = $this->main->getListSelect('recurso', $select, ['recurso.nombre' => 'ASC'], $where2, null, null, ['detalle_medio' => 'id_recurso']);
    $data['medios'] = $medios;

    $cont = count($notasxtematica);
    $cont;
    $i = 0;
    $notas = "[";
    $tematicas = "[";
    foreach ($notasxtematica as $valor) {
      if ($i != $cont - 1) {
        $notas = $notas . '"' . $valor->tema . '",';
        //  $tematicas = $tematicas . $valor->notas . ',';
      } else {
        $notas = $notas .  '"' . $valor->tema . '"]';
        //$tematicas = $tematicas . $valor->notas . ']';
      }
      $i++;
    }
    $data['notasxtematica'] = $notas;

    $tendencias =  $this->main->getListSelect('tendencia', 'id_tendencia,nombre_tendencia', ['id_tendencia' => 'ASC']);
    if ($id_usuario > 0) {
      $query_tenden = "select tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as cant
        	from detalle_medio
        	left join tendencia on detalle_medio.id_tendencia = tendencia.id_tendencia
        	left join nota on nota.id_nota = detalle_medio.id_nota
        	where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59' AND detalle_medio.id_usuario= $id_usuario
        	group by tendencia.nombre_tendencia";
    } else {
      $query_tenden = "select tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as cant
        	from detalle_medio
        	left join tendencia on detalle_medio.id_tendencia = tendencia.id_tendencia
        	left join nota on nota.id_nota = detalle_medio.id_nota
        	where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59'
        	group by tendencia.nombre_tendencia";
    }

    $consulta_ten = $this->db->query($query_tenden);
    $cont_tenden = $consulta_ten->result();
    $conta_ten = count($cont_tenden);
    $i = 0;
    $tendencias = "[";
    $notas_t = "[";
    $notas_ba = "";
    foreach ($cont_tenden as &$valor) {
      if ($i != $conta_ten - 1) {
        $tendencias = $tendencias . '"' . $valor->nombre_tendencia . '",';
        $notas_t = $notas_t . $valor->cant . ',';
        $notas_ba = $notas_ba . $valor->cant . '-';
      } else {
        $tendencias = $tendencias .  '"' . $valor->nombre_tendencia . '"]';
        $notas_t = $notas_t . $valor->cant . ']';
        $notas_ba = $notas_ba . $valor->cant;
      }
      $i++;
    }
    $data['tendencias'] = $tendencias;
    $data['notas_t'] = $notas_t;
    $data['notas_ba'] = $notas_ba;

    $this->load->view('normal/reporte/tematica', $data, FALSE);
  }
  public function imprimir()
  {
    $fecha_i = set_value('fecha_in');
    //$fecha_f = set_value('fecha_fi');
    $id_usu = set_value('id_usuario');
    

    if (empty($id_usu)) {
      $id_usuario = $this->session->sistema->id_usuario;
      $id_rol = $this->main->getField('usuario', 'id_rol', ['id_usuario' => $id_usuario]);
      if ($id_rol == 1) {
        $id_usuario = 0;
      }
    } else {
      $id_usuario = $id_usu;
    }
    $data['fecha_i'] = $fecha_i;
    //$data['fecha_f'] = $fecha_f;
    $data['id_usuario'] = $id_usuario;
    $data['lis_tendencias'] = $this->main->getListSelect('tendencia', 'id_tendencia,nombre_tendencia', ['nombre_tendencia' => 'ASC']);
    if ($id_usuario > 0) {      
      $query_i = "select nombre,count(detalle_medio.id_nota) as contador,t.tema
  		from detalle_medio
  		left join recurso on recurso.id_recurso = detalle_medio.id_recurso
  		left join nota  on nota.id_nota = detalle_medio.id_nota
  		 left join tema t on t.id_tema = nota.id_tema
  		where nota.id_estado=1 and
  		nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59' and detalle_medio.id_usuario = $id_usuario
  		group by nombre,t.tema";
    } else {
      $query_i = "select nombre,count(detalle_medio.id_nota) as contador,t.tema
   		from detalle_medio
   		left join recurso on recurso.id_recurso = detalle_medio.id_recurso
   		left join nota  on nota.id_nota = detalle_medio.id_nota
   		 left join tema t on t.id_tema = nota.id_tema
   		where nota.id_estado=1 and
   		nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59'
   		group by nombre,t.tema";
    }
    $consulta = $this->db->query($query_i);
    $data['listas_cont'] = $consulta->result();


    $where3['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where3['nota.fecha_registro <='] = $fecha_i . ' 23:59:59';
    $where3['nota.id_estado'] = 1;
    if ($id_usuario > 0) {
      $where3['detalle_medio.id_usuario'] = $id_usuario;
    }
    $tot = $this->main->total('detalle_medio', $where3, ['nota' => 'id_nota']);
    $data['tot'] = $tot;

    $select = 'nota.id_tema,tema.tema';
    $where['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where['nota.fecha_registro <='] = $fecha_i . ' 23:59:59';
    $where['nota.id_estado'] = 1;

    if ($id_usuario > 0) {
      $where['detalle_medio.id_usuario'] = $id_usuario;
    }
    $notasxtematica = $this->main->getListSelect('nota', $select, ['tema.tema' => 'ASC'], $where, null, null, ['tema' => 'id_tema', 'detalle_medio' => 'id_nota']);
    $data['temas'] = $notasxtematica;
    if ($id_usuario > 0) {
      $query_tem = "select tema.tema,count(detalle_medio.id_nota) as total
                     	from nota
                     	left join tema on nota.id_tema = tema.id_tema
                     	left join detalle_medio on nota.id_nota = detalle_medio.id_nota
                     	where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59' AND detalle_medio.id_usuario = $id_usuario
                     	group by tema.tema";
    } else {
      $query_tem = "select tema.tema,count(detalle_medio.id_nota) as total
                     	from nota
                     	left join tema on nota.id_tema = tema.id_tema
                     	left join detalle_medio on nota.id_nota = detalle_medio.id_nota
                     	where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59'
                     	group by tema.tema";
    }

    $consulta = $this->db->query($query_tem);
    $cont_temas = $consulta->result();
    $conta_t = count($cont_temas);
    $i = 0;
    $tematicas = "";
    $not = "";
    foreach ($cont_temas as &$valor) {
      if ($i != $conta_t - 1) {

        $tema = substr($valor->tema, 0, 7);
        $tematicas = $tematicas . '"' . $tema . '",';
        $porcentaje = number_format(($valor->total * 100) / $tot, 2, ".", "");
        $not = $not . $porcentaje . ',';
      } else {
        $tema = substr($valor->tema, 0, 7);
        $tematicas = $tematicas .  '"' . $tema . '"';
        $porcentaje = number_format(($valor->total * 100) / $tot, 2, ".", "");
        $not = $not . $porcentaje;
      }
      $i++;
    }
    $data['tematicas'] = $tematicas;
    $data['not'] = $not;

    $select = 'recurso.id_recurso,recurso.nombre';

    $where2['recurso.id_estado'] = 1;
    $where2['detalle_medio.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where2['detalle_medio.fecha_registro <='] = $fecha_i . ' 23:59:59';
    if ($id_usuario > 0) {
      $where2['detalle_medio.id_usuario'] = $id_usuario;
    }

    $medios = $this->main->getListSelect('recurso', $select, ['recurso.nombre' => 'ASC'], $where2, null, null, ['detalle_medio' => 'id_recurso']);
    $data['medios'] = $medios;

    $cont = count($notasxtematica);
    $cont;
    $i = 0;
    $notas = "[";
    $tematicas = "[";
    foreach ($notasxtematica as $valor) {
      if ($i != $cont - 1) {
        $notas = $notas . '"' . $valor->tema . '",';
        //  $tematicas = $tematicas . $valor->notas . ',';
      } else {
        $notas = $notas .  '"' . $valor->tema . '"]';
        //$tematicas = $tematicas . $valor->notas . ']';
      }
      $i++;
    }
    $data['notasxtematica'] = $notas;

    $tendencias =  $this->main->getListSelect('tendencia', 'id_tendencia,nombre_tendencia', ['id_tendencia' => 'ASC']);
    if ($id_usuario > 0) {
      $query_tenden = "select tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as cant
          from detalle_medio
          left join tendencia on detalle_medio.id_tendencia = tendencia.id_tendencia
          left join nota on nota.id_nota = detalle_medio.id_nota
          where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59' AND detalle_medio.id_usuario= $id_usuario
          group by tendencia.nombre_tendencia";
    } else {
      $query_tenden = "select tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as cant
          	from detalle_medio
          	left join tendencia on detalle_medio.id_tendencia = tendencia.id_tendencia
          	left join nota on nota.id_nota = detalle_medio.id_nota
          	where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59'
          	group by tendencia.nombre_tendencia";
    }
    $consulta_ten = $this->db->query($query_tenden);
    $cont_tenden = $consulta_ten->result();
    $conta_ten = count($cont_tenden);
    $data['conta_ten'] = $cont_tenden;
    $i = 0;
    $tendencias = "";
    $notas_t = "";
    $notas_b = "";
    foreach ($cont_tenden as &$valor) {
      if ($i != $conta_ten - 1) {
        $tendencias = $tendencias . "'" . $valor->nombre_tendencia . "',";
        $notas_t = $notas_t . $valor->cant . ',';
        $notas_b = $notas_b . $valor->cant . '-';
      } else {
        $tendencias = $tendencias .  "'" . $valor->nombre_tendencia . "'";
        $notas_t = $notas_t . $valor->cant;
        $notas_b = $notas_b . $valor->cant;
      }
      $i++;
    }
    $data['tendencias'] = $tendencias;
    $data['notas_t'] = $notas_t;
    $data['notas_ba'] = $notas_b;
    $data['fecha_i'] = $fecha_i;
    //$data['fecha_f'] = $fecha_f;
    $this->load->view('normal/reporte/imprimir_reporte', $data);
  }
  public function torta()
  {
    //die($fechas);
    //$fechas = explode('%', $fechas);
    $fecha_ini = date('Y-m-d');
    //$fecha_fin = date('Y-m-d');

    $where3['nota.fecha_registro >'] = $fecha_ini . ' 00:00:00';
    $where3['nota.fecha_registro <='] = $fecha_ini . ' 23:59:59';
    $where3['nota.id_estado'] = 1;
    $tot = $this->main->total('detalle_medio', $where3, ['nota' => 'id_nota']);

    $query_tem = "select tema.tema,count(detalle_medio.id_nota) as total
                    from nota
                    left join tema on nota.id_tema = tema.id_tema
                    left join detalle_medio on nota.id_nota = detalle_medio.id_nota
                    where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_ini . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_ini . " 23:59:59'
                    group by tema.tema";
    $consulta = $this->db->query($query_tem);
    $cont_temas = $consulta->result();
    $conta_t = count($cont_temas);
    $i = 0;
    $tematicas = "";
    $not = "";
    foreach ($cont_temas as &$valor) {
      if ($i != $conta_t - 1) {

        $tema = substr($valor->tema, 0, 7);
        $tematicas = $tematicas . '"' . $tema . '",';
        $porcentaje = number_format(($valor->total * 100) / $tot, 2, ".", "");
        $not = $not . $porcentaje . ',';
      } else {
        $tema = substr($valor->tema, 0, 7);
        $tematicas = $tematicas .  '"' . $tema . '"';
        $porcentaje = number_format(($valor->total * 100) / $tot, 2, ".", "");
        $not = $not . $porcentaje;
      }
      $i++;
    }
    $conta_te = explode(',', $not);
    $tematicas = explode(',', $tematicas);


    $data = $conta_te;

    /*  print_r($data);
        die();*/

    //$data = array(40,21,17,14,23);

    // Create the Pie Graph.
    $graph = new PieGraph(350, 250);

    $theme_class = "DefaultTheme";
    //$graph->SetTheme(new $theme_class());

    // Set A title for the plot
    $graph->title->Set("A Simple Pie Plot");
    $graph->SetBox(true);

    // Create
    $p1 = new PiePlot($data);
    $graph->Add($p1);

    $p1->ShowBorder();
    $p1->SetColor('black');
    $p1->SetSliceColors(array('#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3'));
    $graph->Stroke();
  }
  public function funcionario()
  {
    $fecha_inicial = set_value('fecha_ini_submit');
    $fecha_fin = set_value('fecha_fin_submit');

    /*$fecha_inicial = date('Y-m-d');
    $fecha_fin = date('Y-m-d');*/


    if (empty($fecha_inicial) && empty($fecha_fin)) {
      $fecha_i = date('Y-m-d');
      $fecha_f = date('Y-m-d');
    } else {
      $fecha_i = $fecha_inicial;
      $fecha_f = $fecha_fin;
    }
    $data['fecha_i'] = $fecha_i;
    $data['fecha_f'] = $fecha_f;

    $where3['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where3['nota.fecha_registro <='] = $fecha_f . ' 23:59:59';
    $where3['nota.id_estado'] = 1;
    $tot = $this->main->total('detalle_medio', $where3, ['nota' => 'id_nota']);
    $data['tot'] = $tot;

    $where5['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where5['nota.fecha_registro <='] = $fecha_f . ' 23:59:59';
    $where5['nota.id_estado'] = 1;
    $tota_not = $this->main->total('nota', $where5,['detalle_medio'=> 'id_nota']);
    $data['tota_not'] = $tota_not;

    $select = 'recurso.id_recurso,recurso.nombre';

    $where2['recurso.id_estado'] = 1;
    $where2['detalle_medio.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where2['detalle_medio.fecha_registro <='] = $fecha_f . ' 23:59:59';
    $medios = $this->main->getListSelect('recurso', $select, ['recurso.nombre' => 'ASC'], $where2, null, null, ['detalle_medio' => 'id_recurso']);
    $data['medios'] = $medios;

    $query_fun = "select detalle_medio.id_usuario,persona.nombre_completo,count(detalle_medio.id_detalle_medio) as total
     	from detalle_medio
      left join usuario on  detalle_medio.id_usuario = usuario.id_usuario
      left join persona on usuario.id_persona = persona.id_persona
      left join nota on nota.id_nota = detalle_medio.id_nota
     	where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_f . " 23:59:59'
     	group by detalle_medio.id_usuario,persona.nombre_completo ORDER BY persona.nombre_completo ASC";
    $consulta = $this->db->query($query_fun);
    $cont_func = $consulta->result();
    $conta_fun = count($cont_func);

    
    $i = 0;
    $funcionarios = "[";
    $cont_f = "[";

    //print_r($conta_fun);
    foreach ($cont_func as $dat_f) {
      if ($i != $conta_fun - 1) {
        $funcionarios = $funcionarios . '"' . $dat_f->nombre_completo . '",';

        $porcentaje = number_format(($dat_f->total * 100) / $tota_not, 2, ".", "");
        $cont_f = $cont_f . $porcentaje . ',';
      } else {
        $funcionarios = $funcionarios .  '"' . $dat_f->nombre_completo . '"]';
        $porcentaje = number_format(($dat_f->total * 100) / $tota_not, 2, ".", "");
        $cont_f = $cont_f . $porcentaje . ']';
      }
      $i++;
    }
    $data['funcionarios_array'] = $funcionarios;
    $data['cont_f'] = $cont_f;




    if (!empty($medios)) {
      $select8 = 'persona.nombre_completo,detalle_medio.id_usuario';
      $where['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
      $where['nota.fecha_registro <='] = $fecha_f . ' 23:59:59';
      $where['nota.id_estado'] = 1;
      $this->db->join('usuario', 'detalle_medio.id_usuario = usuario.id_usuario', 'left');
      $this->db->join('persona', 'usuario.id_persona = persona.id_persona', 'left');
      $this->db->join('nota', 'nota.id_nota = detalle_medio.id_nota', 'left');
      $funcionarios = $this->main->getListSelect('detalle_medio', $select8, ['persona.nombre_completo' => 'ASC'], $where, null, null);

      $data['funcionarios'] = $funcionarios;
      $cont = count($funcionarios);
      $cont;
      $i = 0;


      $registroxfuncionario = "[";
      foreach ($funcionarios as &$valor) {
        if ($i != $cont - 1) {
          $registroxfuncionario = $registroxfuncionario . '"' . $valor->nombre_completo . '",';
        } else {
          $registroxfuncionario = $registroxfuncionario .  '"' . $valor->nombre_completo . '"]';
        }
        $i++;
      }
      $data['registroxfuncionario'] = $registroxfuncionario;
      /*

  //print_r($registroxfuncionario);
      //grafico de barras
      $arreglo = "";
      $cantidad = [];
      $tipos = "";

      foreach ($funcionarios as $funcionario) {
        $tam = count($medios);$i=0;
        foreach($medios as $medio){
          $query_fu = "select count(detalle_medio.id_nota) as contad, recurso.nombre
          from detalle_medio
          left join recurso on recurso.id_recurso = detalle_medio.id_recurso
          left join nota  on nota.id_nota = detalle_medio.id_nota
          where nota.id_estado=1 and
          nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_f." 23:59:59' AND nota.id_usuario= '$funcionario->id_usuario' and nombre = '$medio->nombre' group by  recurso.nombre";
          $consulta = $this->db->query($query_fu);
          $listas_contador = $consulta->result();


          if ($i != $tam - 1) {
            $tipos = $tipos . '"' . $listas_contador[0]->nombre . '",';

          } else {
            $tipos = $tipos . '"' .  $listas_contador[0]->nombre . '"';

          }


        $i++;
        }

      }
  $tam_fun = count($funcionarios); $p=0;
      foreach($medios as $medio){

        foreach ($funcionarios as $funcionario) {
          $query_fu = "select count(detalle_medio.id_nota) as contad, recurso.nombre
          from detalle_medio
          left join recurso on recurso.id_recurso = detalle_medio.id_recurso
          left join nota  on nota.id_nota = detalle_medio.id_nota
          where nota.id_estado=1 and
          nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_f." 23:59:59' AND nota.id_usuario= '$funcionario->id_usuario' and nombre = '$medio->nombre' group by  recurso.nombre";
          $consulta = $this->db->query($query_fu);
          $listas_contador = $consulta->result();
          if ($p != $tam_fun - 1) {
              $arreglo = $arreglo. '' .$listas_contador[0]->contad. ',';
          } else {
              $arreglo = $arreglo. '' .$listas_contador[0]->contad ;
          }
          $p++;

          //array_push($cantidad, $arreglo);
        }
      }
  print_r($arreglo);

      $arreglo= explode(',',$arreglo);
      //print_r($arreglo);
      //die();
      $p=0;

      $ind=0;
      /*for ($i = 0; $i < count($arreglo); $i++) {
        $p=0;
        if ($p <= $tam_fun - 1) {
            $contadores[$p] = $contadores[$p].''.$arreglo[$in]. ',';
        } else {
            $contadores[$p] = $contadores[$p].''.$arreglo[$in] ;
        }
        $p++;
        $in=$in+$tamfun-1;
      }*/
      //$contadores[];

      /*$contadores[0]=$arreglo[0].','.$arreglo[1];
      $contadores[1]=$arreglo[2].','.$arreglo[3];
      $contadores[2]= $arreglo[4].','.$arreglo[5];*/
      //print_r($contadores[0]);

      /*$tipos= explode(',',$tipos);

      $colores = '"#4fb9a8","#f9b154","#4ac1e0","#ae1857","#009877","#6d56a0","#ea547c"';
          $colores = explode(',', $colores);
      //  print_r(count($cantidad[3]));
      //  die();
      $tam_medios = count($medios);
        //print_r($tam_medios);
          $armado = "[";

          for ($i = 0; $i < $tam_medios; $i++) {
              if ($i < $tam_medios) {
                  $armado = $armado . "{label: " . $tipos[$i] . ', backgroundColor: ' . $colores[$i] . ', data: [' . $contadores[$i] . "]},";
                  //}

              } else {
                  $armado = $armado . "{label: " . $tipos[$i] . ', backgroundColor: ' . $colores[$i] . ', data: [' . $contadores[$i] . "]}";

              }
          }
          $armado = $armado . "]";

          $data["datasets"] = $armado;*/
    }

    $this->load->view('normal/reporte/funcionario', $data, FALSE);
  }

  public function imprimir_fun()
  {
    $fecha_i = set_value('fecha_in');
    $fecha_f = set_value('fecha_fi');
    //print_r($fecha_i);
    //print_r($fecha_f);
    //die();
    $select = 'recurso.id_recurso,recurso.nombre';

    $where2['recurso.id_estado'] = 1;
    $where2['detalle_medio.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where2['detalle_medio.fecha_registro <='] = $fecha_f . ' 23:59:59';
    $medios = $this->main->getListSelect('recurso', $select, ['recurso.nombre' => 'ASC'], $where2, null, null, ['detalle_medio' => 'id_recurso']);
    $data['medios'] = $medios;

    $where3['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where3['nota.fecha_registro <='] = $fecha_f . ' 23:59:59';
    $where3['nota.id_estado'] = 1;
    $tot = $this->main->total('detalle_medio', $where3, ['nota' => 'id_nota']);
    $data['tot'] = $tot;

    $where5['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where5['nota.fecha_registro <='] = $fecha_f . ' 23:59:59';
    $where5['nota.id_estado'] = 1;
    $tota_not = $this->main->total('nota', $where5,['detalle_medio'=> 'id_nota']);
    $data['tota_not'] = $tota_not;


    $query_fun = "select detalle_medio.id_usuario,persona.nombre_completo,count(detalle_medio.id_detalle_medio) as total
     	from detalle_medio
      left join usuario on  detalle_medio.id_usuario = usuario.id_usuario
      left join persona on usuario.id_persona = persona.id_persona
      left join nota on nota.id_nota = detalle_medio.id_nota
     	where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_f . " 23:59:59'
     	group by detalle_medio.id_usuario,persona.nombre_completo ORDER BY persona.nombre_completo ASC";
    $consulta = $this->db->query($query_fun);
    $cont_func = $consulta->result();

    $conta_fun = count($cont_func);

    $i = 0;
    $funcionarios = "[";
    $cont_f = "[";
    $cont_fun_t = "";

    //print_r($conta_fun);
    foreach ($cont_func as $dat_f) {
      if ($i != $conta_fun - 1) {
        $funcionarios = $funcionarios . '"' . $dat_f->nombre_completo . '",';

        $porcentaje = number_format(($dat_f->total * 100) / $tota_not, 2, ".", "");
        $cont_f = $cont_f . $porcentaje . ',';
        $cont_fun_t = $cont_fun_t . $porcentaje . ',';
      } else {
        $funcionarios = $funcionarios .  '"' . $dat_f->nombre_completo . '"]';
        $porcentaje = number_format(($dat_f->total * 100) / $tota_not, 2, ".", "");
        $cont_f = $cont_f . $porcentaje . ']';
        $cont_fun_t = $cont_fun_t . $porcentaje;
      }
      $i++;
    }
    $data['funcionarios_array'] = $funcionarios;
    $data['cont_f'] = $cont_f;
    $data['cont_fu'] = $cont_fun_t;

    $select8 = 'persona.nombre_completo,detalle_medio.id_usuario';
    $where['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where['nota.fecha_registro <='] = $fecha_f . ' 23:59:59';
    $where['nota.id_estado'] = 1;
    $this->db->join('usuario', 'detalle_medio.id_usuario = usuario.id_usuario', 'left');
    $this->db->join('persona', 'usuario.id_persona = persona.id_persona', 'left');
    $this->db->join('nota', 'nota.id_nota = detalle_medio.id_nota', 'left');
    $funcionarios = $this->main->getListSelect('detalle_medio', $select8, ['persona.nombre_completo' => 'ASC'], $where, null, null);




    $data['funcionarios'] = $funcionarios;
    $data['fecha_i'] = $fecha_i;
    $data['fecha_f'] = $fecha_f;
    $this->load->view('normal/reporte/imprimir_reporte_funcionario', $data);
  }
}
