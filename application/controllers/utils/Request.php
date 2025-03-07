<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Request extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    //Do your magic here

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
  }

  function cambiar_estado()
  {
    $elemento = set_value('id_elemento');
    $tabla = set_value('tabla');

    $id_estado = $this->main->getField($tabla, 'id_estado', ['id_' . $tabla => $elemento]);

    if ($id_estado == 1) {
      $estado['id_estado'] = 2;
      $this->main->update($tabla, $estado, ['id_' . $tabla => $elemento]);
      $info = 0;
    } else {
      $estado['id_estado'] = 1;
      $this->main->update($tabla, $estado, ['id_' . $tabla => $elemento]);
      $info = 1;
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode([
        'status' => true,
        'response' => $info
      ]));
  }

  public function recuperar_info()
  {
    $id_elemento = set_value('id_elemento');
    $tabla = set_value('tabla');

    $dependencia = $this->main->get($tabla, ['id_' . $tabla => $id_elemento]);

    $info['data'] = $dependencia;

    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode([
        'status' => true,
        'response' => $info
      ]));
  }
  public function lista_funcionarios()
  {
    $funcionarios = $this->main->getListSelect('usuario', 'usuario.id_usuario,persona.nombre_completo', ['persona.nombre_completo' => 'ASC'], ['usuario.id_rol' => 2], null, null, ['persona' => 'id_persona']);
    //$funcionarios = $this->main->dropdown($funcionarios);

    $info['funcionarios'] = $funcionarios;
    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode([
        'status' => true,
        'response' => $info
      ]));
  }
  public function vista_tabla()
  {
    $fecha_i = $_POST['fecha_submit'];

    if(isset($_POST['funcionario'])){
      $id_usuario = $_POST['funcionario'];
    }
    else{
      $id_usuario = "";
    }
    
    if (empty($fecha_i)) {
      $fecha_i = date('Y-m-d');
    }

    $select = 'recurso.id_recurso,recurso.nombre';
    $where2['recurso.id_estado'] = 1;
    $where2['detalle_medio.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where2['detalle_medio.fecha_registro <='] = $fecha_i . ' 23:59:59';
    if ($id_usuario != "") {
      $where2['detalle_medio.id_usuario'] = $id_usuario;
    }
    $medios = $this->main->getListSelect('recurso', $select, ['recurso.nombre' => 'ASC'], $where2, null, null, ['detalle_medio' => 'id_recurso']);
    $data['medios'] = $medios;

    $data['lis_tendencias'] = $this->main->getListSelect('tendencia', 'id_tendencia,nombre_tendencia', ['nombre_tendencia' => 'ASC']);


    $data['fecha_i'] = $fecha_i;
    $data['id_usuario'] = $id_usuario;

    $this->load->view('normal/reporte/vista', $data, TRUE);
  }
  public function tabla_tendencias()
  {
    $fecha_i = $_POST['fecha_submit'];

    if(isset($_POST['funcionario'])){
      $id_usuario = $_POST['funcionario'];
    }
    else{
      $id_usuario = 0;
    }

    if (empty($fecha_i)) {
      $fecha_i = date('Y-m-d');
    }

    $id_depend = 1;
    $where3['nota.id_estado'] = 1;
    $where3['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where3['nota.fecha_registro <='] = $fecha_i . ' 23:59:59';
    $where3['detalle_medio.id_tendencia ='] = $id_depend;
    if ($id_usuario > 0) {
      $where3['nota.id_usuario ='] = $id_usuario;
    }

    $listas_tendencia = $this->main->getListSelectJoin('detalle_medio', 'tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as total', null, $where3, null, null, ['tendencia' => 'id_tendencia', 'nota' => 'id_nota'], ['tendencia.nombre_tendencia']);
    $data['tendencia_uno'] = $listas_tendencia;

    $id_depend = 2;
    $where3['nota.id_estado'] = 1;
    $where3['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where3['nota.fecha_registro <='] = $fecha_i . ' 23:59:59';
    $where3['detalle_medio.id_tendencia ='] = $id_depend;
    if ($id_usuario > 0) {
      $where3['nota.id_usuario ='] = $id_usuario;
    }

    $listas_tendencia2 = $this->main->getListSelectJoin('detalle_medio', 'tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as total', null, $where3, null, null, ['tendencia' => 'id_tendencia', 'nota' => 'id_nota'], ['tendencia.nombre_tendencia']);
    $data['tendencia_dos'] = $listas_tendencia2;

    $id_depend = 3;
    $where3['nota.id_estado'] = 1;
    $where3['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where3['nota.fecha_registro <='] = $fecha_i . ' 23:59:59';
    $where3['detalle_medio.id_tendencia ='] = $id_depend;
    if ($id_usuario > 0) {
      $where3['nota.id_usuario ='] = $id_usuario;
    }

    $listas_tendencia3 = $this->main->getListSelectJoin('detalle_medio', 'tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as total', null, $where3, null, null, ['tendencia' => 'id_tendencia', 'nota' => 'id_nota'], ['tendencia.nombre_tendencia']);


    $data['tendencia_tres'] = $listas_tendencia3;

    if (empty($listas_tendencia) && empty($listas_tendencia3) && empty($listas_tendencia2)) {
      return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode([
        'status' => false,
        'response' => $data
      ]));
     
    } else {
     
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
          'status' => true,
          'response' => $data
        ]));
    }
  }

  public function tendencias_barras()
  {
    $fecha_i = $_POST['fecha_submit'];
    
    if(isset($_POST['funcionario'])){
      $id_usuario = $_POST['funcionario'];
    }
    else{
      $id_usuario = 0;
    }

    if (empty($fecha_i)) {
      $fecha_i = date('Y-m-d');
    }

    if ($id_usuario > 0) {
      $query_tenden = "select tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as cant
      from detalle_medio
      left join tendencia on detalle_medio.id_tendencia = tendencia.id_tendencia
      left join nota on nota.id_nota = detalle_medio.id_nota
      where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59' AND nota.id_usuario= $id_usuario
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
    if (!empty($cont_tenden)) {
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

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
          'status' => true,
          'response' => $data
        ]));
    } else {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
          'status' => false
        ]));
    }
  }


  public function armar_reporte_tematica()
  {
    $fecha_i = $_POST['fecha_submit'];
    $id_usuario = $_POST['funcionario'];
    if (empty($id_usuario)) {
      $id_usuario = $this->session->sistema->id_usuario;
    }

    if (empty($fecha_i)) {
      $fecha_i = date('Y-m-d');
    }

    $select = 'recurso.id_recurso,recurso.nombre';

    $where2['recurso.id_estado'] = 1;
    $where2['detalle_medio.fecha_registro >'] = $fecha_i . ' 00:00:00';
    $where2['detalle_medio.fecha_registro <='] = $fecha_i . ' 23:59:59';
    if (!empty($id_usuario)) {
      $where2['detalle_medio.id_usuario'] = $id_usuario;
    }
    $medios = $this->main->getListSelect('recurso', $select, ['recurso.nombre' => 'ASC'], $where2, null, null, ['detalle_medio' => 'id_recurso']);
    $info['medios'] = $medios;
    if (!empty($medios)) {

      $id_depend = 1;
      while ($id_depend <= 3) {
        $where3['nota.id_estado'] = 1;
        $where3['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
        $where3['nota.fecha_registro <='] = $fecha_i . ' 23:59:59';
        $where3['detalle_medio.id_tendencia ='] = $id_depend;
        if ($id_usuario > 0) {
          $where3['nota.id_usuario ='] = $id_usuario;
        }

        $listas_tendencia = $this->main->getListSelectJoin('detalle_medio', 'tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as total', null, $where3, null, null, ['tendencia' => 'id_tendencia', 'nota' => 'id_nota'], ['tendencia.nombre_tendencia']);

        $id_depend++;
      }

      if ($id_usuario > 0) {
        $query_tenden = "select tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as cant
        	from detalle_medio
        	left join tendencia on detalle_medio.id_tendencia = tendencia.id_tendencia
        	left join nota on nota.id_nota = detalle_medio.id_nota
        	where nota.id_estado=1 and nota.fecha_registro > '" . $fecha_i . " 00:00:00' AND nota.fecha_registro <= '" . $fecha_i . " 23:59:59' AND nota.id_usuario= $id_usuario
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
      $funcionarios = $this->main->getListSelect('usuario', 'usuario.id_usuario,persona.nombre_completo', ['persona.nombre_completo' => 'ASC'], ['usuario.id_rol' => 2], null, null, ['persona' => 'id_persona']);
    

      $info['tendencias'] = $tendencias;
      $info['notas_t'] = $notas_t;
      $info['notas_ba'] = $notas_ba;
      $info['data'] = $funcionarios;

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
          'status' => true,
          'response' => $info
        ]));
    } else {

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
          'status' => false

        ]));
    }
  }

  public function detalle_tendencias()
  {
    $fecha = set_value('fecha');
    $tendencia = set_value('tendencia');

    if (!$fecha || !$tendencia) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
          'status' => false
        ]));
    }

    $select = "tema, nombre_tendencia, nota.detalle, nota.fecha_registro, turno, recurso.nombre, to_char(nota.fecha_registro,'DD/MM/YYYY') as fecha";

    $where = "tema.id_estado = 1 and nota.id_estado = 1 and nombre_tendencia = '".$tendencia."' AND nota.fecha_registro BETWEEN '" . $fecha . " 00:00'" . " AND '" . $fecha . " 23:59'";

    $this->db->join('tendencia', 'tendencia.id_tendencia = detalle_medio.id_tendencia', 'left');
    $this->db->join('nota', 'nota.id_nota = detalle_medio.id_nota', 'left');;
    $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
    $this->db->join('turno', 'turno.id_turno = detalle_medio.id_turno', 'left');
    $this->db->join('recurso', 'recurso.id_recurso = detalle_medio.id_recurso', 'left');
    $reporte = $this->main->getListSelectWD('detalle_medio', $select, ['tema' => 'ASC'], $where);
    $data['cantidad'] = count($reporte);
    $data['reporte'] = $reporte;

    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode([
        'status' => true,
        'response' => $data

      ]));
  }
}
