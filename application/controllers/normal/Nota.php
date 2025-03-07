<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nota extends CI_Controller
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

  public function index($search_custon = '', $draw = 1, $gestionSearch = '')
  {
    $start = $this->input->get('start');
    $draw = $this->input->get('draw');
    $length = $this->input->get('length');
    $search_value = $_GET['search']['value'];
    $flag = false;


    $fecha_ini = $_GET['filter_fechaini'];
    $fecha_fin = $_GET['filter_fechafin'];
    if ($fecha_ini != '') {
      $fecha_ini = $fecha_ini . " 00:00:00";
    }
    if ($fecha_fin != '') {
      $fecha_fin = $fecha_fin . " 23:59:59";
    }

    if ($fecha_ini != '') {
      $flag = true;
      $where['nota.fecha_registro >='] = $fecha_ini;
    }
    if ($fecha_fin != '') {
      $flag = true;
      $where['nota.fecha_registro >='] = $fecha_ini;
      $where['nota.fecha_registro <='] = $fecha_fin;
    }

    if (!$flag) {
      $where['nota.fecha_registro >'] = date('Y-m-d 00:00:00');
      $where['nota.fecha_registro <='] = date('Y-m-d 23:59:59');
    }


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
          /*case '3':
                  $orden['area.nombre_area'] = $dir;
                  break;*/
        case '3':
          $orden['recurso.nombre'] = $dir;
          break;
        case '4':
          $orden['fecha_registro_format'] = $dir;
          break;

        default:
          $orden['dependencia.nombre_dependencia'] = $dir;
          break;
      }
    } else {
      $orden['dependencia.nombre_dependencia'] = 'ASC';
    }

    $search_value = strtoupper($search_value);

    //$this->db->join('area', 'area.id_area = nota.id_area', 'left');
    $this->db->join('dependencia', 'dependencia.id_dependencia = nota.id_dependencia', 'left');;
    $this->db->join('estado', 'estado.id_estado = nota.id_estado', 'left');
    $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
    $contador = $this->main->total('nota', $where);

    if ($search_value != '') {

      $this->db->like('tema.tema', $search_value, 'both', false);
      $this->db->or_like('dependencia.nombre_dependencia', $search_value, 'both', false);
      //  $this->db->or_like('area.nombre_area', $search_value, 'both', false);
      $this->db->or_like('estado.descripcion', $search_value, 'both', false);
    }
    //$this->db->join('area', 'area.id_area = nota.id_area', 'left');
    $this->db->join('dependencia', 'dependencia.id_dependencia = nota.id_dependencia', 'left');;
    $this->db->join('estado', 'estado.id_estado = nota.id_estado', 'left');
    $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');

    $notas = $this->main->getListSelect('nota', "nota.id_nota,dependencia.nombre_dependencia,nota.detalle,nota.adjunto, estado.descripcion, nota.id_tema,tema.tema,dependencia.id_dependencia,nota.id_estado,to_char(nota.fecha_registro,'DD TMMonth YYYY') as fecha_registro_format,nota.fecha_registro,(
        SELECT STRING_AGG(recurso.nombre, ' , ')medio_general
      FROM detalle_medio  LEFT JOIN recurso ON recurso.id_recurso = detalle_medio.id_recurso where detalle_medio.id_nota=nota.id_nota
      GROUP BY detalle_medio.id_nota) as lista_medios", ["nota.id_nota" => 'DESC'], $where);
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

  public function lista()
  {

    $estado = $this->main->getListSelect('estado', 'id_estado,descripcion', ['descripcion' => 'ASC']);
    $data['estados'] = $this->main->dropdown($estado, 'SELECCIONAR');
    $dependencias = $this->main->getListSelect('dependencia', 'id_dependencia,nombre_dependencia', ['nombre_dependencia' => 'ASC'], ['id_estado' => 1]);
    $data['dependencias'] = $this->main->dropdown($dependencias, 'SELECCIONAR LA DEPENDENCIA');
    /*$medios = $this->main->getListSelect('recurso', 'recurso.id_recurso,CONCAT(recurso.nombre,' - ',medio.nombre_medio) as nombre', ['recurso.nombre' => 'ASC'],['recurso.id_estado'=>1],null,null,['medio'=>'id_medio']);*/
    $medios = $this->main->getListSelect('recurso', 'id_recurso,nombre', null, ['recurso.id_estado' => 1]);
    $data['medios'] = $this->main->dropdown($medios, 'SELECCIONAR');
    //$areas = $this->main->getListSelect('area', 'id_area,nombre_area', ['nombre_area' => 'ASC'],['id_estado'=>1]);
    //$data['areas'] = $this->main->dropdown($areas, 'SELECCIONAR');
    $tendencia = $this->main->getListSelect('tendencia', 'id_tendencia,nombre_tendencia', ['nombre_tendencia' => 'ASC']);
    $data['tendencias'] = $this->main->dropdown($tendencia, 'SELECCIONAR');
    $tipo_noticias = $this->main->getListSelect('tipo_noticia', 'id_tipo_noticia,tipo_noticia', ['tipo_noticia' => 'ASC']);
    $data['tipo_noticias'] = $this->main->dropdown($tipo_noticias, 'SELECCIONAR');
    $turnos = $this->main->getListSelect('turno', 'id_turno,turno', ['turno' => 'ASC']);
    $data['turnos'] = $this->main->dropdown($turnos, 'SELECCIONAR');
    $temas = $this->main->getListSelect('tema', 'id_tema,tema', ['tema' => 'ASC'], ['id_estado' => 1]);
    $data['temas'] = $this->main->dropdown($temas, 'SELECCIONAR');

    //$this->db->join('recurso', 'nota.id_recurso = recurso.id_recurso', 'left');
    //$this->db->join('tendencia', 'nota.id_tendencia = tendencia.id_tendencia', 'left');
    //$this->db->join('tipo_noticia', 'nota.id_tipo_noticia = tipo_noticia.id_tipo_noticia', 'left');
    /*  $this->db->join('area', 'area.id_area = nota.id_area', 'left');
      $this->db->join('dependencia', 'dependencia.id_dependencia = nota.id_dependencia', 'left');;
      $this->db->join('estado', 'estado.id_estado = nota.id_estado', 'left');
      $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');

      $query = "(SELECT detalle_medio.id_nota,STRING_AGG(recurso.nombre, ' , ')medio_general
      FROM detalle_medio  LEFT JOIN recurso ON recurso.id_recurso = detalle_medio.id_recursoGROUP BY detalle_medio.id_nota) hora";
      $notas = $this->main->getListSelect('notas', "nota.id_nota,dependencia.nombre_dependencia,nota.detalle,nota.adjunto,area.nombre_area, estado.descripcion, nota.id_tema,tema.tema,area.id_area,dependencia.id_dependencia,nota.id_estado", ["dependencia.nombre_dependencia"=> 'ASC']);
      $data['notas'] = json_encode($notas);*/
    $fecha_ini =  date('Y-m-d') . ' 00:00:00';
    $fecha_fin =  date('Y-m-d') . ' 23:59:59';
    $notas = $this->db->query("SELECT nota.id_nota, dependencia.nombre_dependencia, nota.detalle, nota.adjunto,estado.descripcion, nota.id_tema, tema.tema,dependencia.id_dependencia, nota.id_estado,nota.fecha_registro,to_char(nota.fecha_registro,'DD TMMonth YYYY') as fecha_registro_format ,(
            SELECT STRING_AGG(recurso.nombre, ' , ')medio_general
          FROM detalle_medio  LEFT JOIN recurso ON recurso.id_recurso = detalle_medio.id_recurso where detalle_medio.id_nota=nota.id_nota
          GROUP BY detalle_medio.id_nota) as lista_medios
          FROM nota
          LEFT JOIN dependencia ON dependencia.id_dependencia = nota.id_dependencia
          LEFT JOIN estado ON estado.id_estado = nota.id_estado
          LEFT JOIN tema ON tema.id_tema = nota.id_tema
          where nota.fecha_registro between '" . $fecha_ini . "' and '" . $fecha_fin . "'
          ORDER BY nota.fecha_registro DESC");
    $data['notas'] = json_encode($notas);

    $this->load->view('normal/nota/index', $data, FALSE);
  }

  public function registrar()
  {


    if (isset($_POST['tema']) != 0)
      $this->form_validation->set_rules('tema', lang('tema'), 'required|trim');
    else
      $this->form_validation->set_rules('tema_nue', lang('tema'), 'required|trim|mb_strtoupper');

    if (isset($_POST['dependencia']) != 0)
      $this->form_validation->set_rules('dependencia', lang('dependecia'), 'required|trim');
    else
      $this->form_validation->set_rules('dependencia_nueva', lang('dependecia'), 'required|trim|mb_strtoupper');

    $this->form_validation->set_rules('detalle', lang('detalle'), 'trim');

    if ($this->form_validation->run()) {

      $registro['id_tema']                            = set_value('tema');
      $registro['id_dependencia']                     = set_value('dependencia');
      $registro['detalle']                            = set_value('detalle');

      $id_recurso                                     = set_value('medio');
      $id_tendencia                                   = set_value('tendencia');
      $id_tipo_noticia                                = set_value('tipo_noticia');
      $id_turno                                       = set_value('turno');
      $detalle                                        = set_value('detalle_reg');
      $acciones                                       = set_value('acciones_reg');


      if ($registro['id_tema'] == 0) {
        $tema['tema'] = set_value('tema_nue');
        $tema['id_usuario'] = $this->session->sistema->id_usuario;
        $tema['fecha_registro'] = date('Y-m-d H:i:s');
        $tema['id_estado'] = 1;
        $id_tema_r = $this->main->getField('tema', 'id_tema', ['tema' => $tema['tema']]);
        if (empty($id_tema_r)) {
          $id_tema = $this->main->insert('tema', $tema);
        } else {
          $id_tema = $id_tema_r;
        }
        $registro['id_tema'] = $id_tema;
      }
      if ($registro['id_dependencia'] == 0) {
        $dependencia['nombre_dependencia'] = set_value('dependencia_nueva');
        $dependencia['id_usuario'] = $this->session->sistema->id_usuario;
        $dependencia['fecha_registro'] = date('Y-m-d H:i:s');
        $dependencia['id_estado'] = 1;
        $id_dependencia = $this->main->insert('dependencia', $dependencia);
        $registro['id_dependencia'] = $id_dependencia;
      }


      $registro['id_usuario'] = $this->session->sistema->id_usuario;
      $registro['fecha_registro'] = date('Y-m-d H:i:s');
      $registro['id_estado'] = 1;
      $id = set_value('id_nota');

      if ($id == 0) {

        $id_n = $this->main->insert('nota', $registro);

        $id_usuario = $this->session->sistema->id_usuario;
        $fecha_registro = date('Y-m-d H:i:s');

        $detalle = [];
        foreach ($id_recurso as $key => $value) {
          
          $arreglo_new = ['id_recurso' => $value, 'id_tendencia' => $id_tendencia[$key], 'id_tipo_noticia' => $id_tipo_noticia[$key], 'id_turno' => $id_turno[$key], 'id_nota' => $id_n, 'acciones' => $acciones[$key], 'detalle' => $detalle[$key], 'fecha_registro' => $fecha_registro, 'id_usuario' => $id_usuario];

          array_push($detalle,$arreglo_new);

        }

        $this->db->insert_batch('detalle_medio', $detalle);
        $this->session->set_flashdata('success', lang('registro.dependencia'));

      } else {
        $registro['id_estado']  = set_value('estado');
        $registro['usuario_modificador'] = $this->session->sistema->nombre_completo;
        $registro['fecha_modificacion'] = date('Y-m-d H:i:s');
        $this->main->update('nota', $registro, ['id_nota' => $id]);
        $this->session->set_flashdata('success', lang('medio.modificado'));
      }
      redirect('notas');
    } else {
      $this->session->set_flashdata('alert', lang('tema.vacio'));
      redirect('notas');
    }
  }

  public function subir_archivo()
  {

    $id = set_value('id_nota');
    if (isset($_FILES['archivo']['tmp_name'])) {
      //$ciudadano = $this->main->get('ciudadano',['dni'=>$ciudadano['dni']]);

      $config['file_name'] = 'archivo-' . $id;
      //$config['upload_path'] = $_SERVER['DOCUMENT_ROOT']."solicitudesgamc.cochabamba.bo/uploads/";
      $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/monitoreo/public/archivos/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg|doc|docx|pdf';
      $config['max_size'] = 35000;
      $config['overwrite'] = TRUE;

      $this->load->library('upload', $config);
      $this->upload->initialize($config);


      if (!$this->upload->do_upload('archivo')) {


        $this->session->set_flashdata('alert', $this->upload->display_errors('<div class="error"><i class="icon las la-exclamation-triangle la-2x"></i>', '</div>'));

        redirect('welcome');
      } else {

        $flag = TRUE;
        $path_archivo = $this->upload->data('file_name');
        $config_img['image_library'] = 'gd2';
        //$config_img['source_image'] = $_SERVER['DOCUMENT_ROOT']."solicitudesgamc.cochabamba.bo/uploads/".$path_foto;
        $config_img['source_image'] = $_SERVER['DOCUMENT_ROOT'] . '/monitoreo/public/archivos/' . $path_archivo;
        $config_img['create_thumb'] = FALSE;
        $config_img['maintain_ratio'] = TRUE;
        $config_img['width'] = 500;
        $config_img['height'] = 300;


        $this->load->library('image_lib', $config_img);
        $this->upload->initialize($config_img);
        $this->image_lib->resize();

        $data = array('upload_data' => $this->upload->data());
      }
      $this->main->update('nota', ['adjunto' => $path_archivo], ['id_nota' => $id]);
      $this->session->set_flashdata('success', lang('imagen.subida'));
      redirect('notas');
    }
  }
  function getArchivo()
  {
    $id = $this->input->get('id');
    $select = 'id_nota,adjunto';
    $archivo = $this->main->getSelect('nota', $select, ['id_nota' => $id]);
    //$archivos->list=$archivos;
    echo json_encode($archivo);
  }
  function getNota()
  {
    $id = $this->input->get('id');
    $select = "dependencia.nombre_dependencia,nota.detalle,nota.adjunto, estado.descripcion, nota.id_tema,nota.id_nota,nota.id_estado, dependencia.id_dependencia,nota.adjunto,tema.tema";
    //$this->db->join('recurso', 'nota.id_recurso = recurso.id_recurso', 'left');
    //$this->db->join('tendencia', 'nota.id_tendencia = tendencia.id_tendencia', 'left');
    //$this->db->join('tipo_noticia', 'nota.id_tipo_noticia = tipo_noticia.id_tipo_noticia', 'left');
    //$this->db->join('area', 'nota.id_area = area.id_area', 'left');
    $this->db->join('tema', 'nota.id_tema = tema.id_tema', 'left');
    $this->db->join('dependencia', 'nota.id_dependencia = dependencia.id_dependencia', 'left');;
    $this->db->join('estado', 'estado.id_estado = nota.id_estado', 'left');
    $nota = $this->main->getSelect('nota', $select, ['id_nota' => $id]);
    //$archivos->list=$archivos;
    echo json_encode($nota);
  }
  public function asignar_medio()
  {
    $this->form_validation->set_rules('medio', lang('medio'), 'required');
    $this->form_validation->set_rules('tendencia', lang('tendencia'), 'required');
    $this->form_validation->set_rules('tipo_noticia', lang('tipo-noticia'), 'required');
    $this->form_validation->set_rules('turno', lang('turno'), 'required');
    $this->form_validation->set_rules('detalle', lang('detalle'), 'trim');
    $this->form_validation->set_rules('acciones', lang('accciones'), 'trim');

    if ($this->form_validation->run()) {

      $registro['id_recurso']                         = set_value('medio');
      $registro['id_tendencia']                       = set_value('tendencia');
      $registro['id_tipo_noticia']                    = set_value('tipo_noticia');
      $registro['id_turno']                           = set_value('turno');
      $registro['id_usuario']                         = $this->session->sistema->id_usuario;
      $registro['fecha_registro']                     = date('Y-m-d H:i:s');
      $registro['id_nota']                            = set_value('id_nota');
      $registro['detalle']                            = set_value('detalle');
      $registro['acciones']                         = set_value('acciones');

      $this->main->insert('detalle_medio', $registro);
      $this->session->set_flashdata('success', lang('registro.dependencia'));

      redirect('notas');
    }
  }
  function getDetalleMedio()
  {
    $id = $this->input->get('id');
    $select = "recurso.nombre,tendencia.nombre_tendencia,tipo_noticia.tipo_noticia,detalle_medio.id_detalle_medio,recurso.id_recurso,recurso.nombre,tipo_noticia.id_tipo_noticia, recurso.id_estado, tendencia.id_tendencia,turno.id_turno,turno,detalle_medio.detalle,detalle_medio.acciones";
    $this->db->join('recurso', 'detalle_medio.id_recurso = recurso.id_recurso', 'left');
    $this->db->join('turno', 'detalle_medio.id_turno = turno.id_turno', 'left');
    $this->db->join('tipo_noticia', 'detalle_medio.id_tipo_noticia = tipo_noticia.id_tipo_noticia', 'left');
    $this->db->join('tendencia', 'detalle_medio.id_tendencia = tendencia.id_tendencia', 'left');;
    $nota = $this->main->getListSelect('detalle_medio', $select, ["recurso.nombre" => 'ASC'], ['detalle_medio.id_nota' => $id], null, null);
    //$archivos->list=$archivos;
    echo json_encode($nota);
  }
}
