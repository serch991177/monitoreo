<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dependencia extends CI_Controller
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

        $columna = $_GET['order'][0]['column'];
        $dir = $_GET['order'][0]['dir'];

        if ($columna != '') {
            switch ($columna) {
                case '1':
                    $orden['dependencia.nombre_dependencia'] = $dir;
                    break;
                /*case '2':
                    $orden['dependencia.detalle'] = $dir;
                    break;*/
                case '2':
                    $orden['estado.descripcion'] = $dir;
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
            //$this->db->or_like('dependencia.detalle', $search_value, 'both', false);
            $this->db->or_like('estado.descripcion', $search_value, 'both', false);
        }

        $this->db->join('estado', 'dependencia.id_estado = estado.id_estado', 'left');
        $contador = $this->main->total('dependencia');

        if ($search_value != '') {

            $this->db->like('dependencia.nombre_dependencia', $search_value, 'both', false);
            //$this->db->or_like('dependencia.detalle', $search_value, 'both', false);
            $this->db->or_like('estado.descripcion', $search_value, 'both', false);
        }

        $this->db->join('estado', 'dependencia.id_estado = estado.id_estado', 'left');
        $dependencias = $this->main->getListSelect('dependencia', "dependencia.nombre_dependencia, estado.descripcion, dependencia.id_dependencia, dependencia.id_estado", $orden, null, $length, $start);

        $data = $dependencias;

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

        $this->db->join('estado', 'dependencia.id_estado = estado.id_estado', 'left');
        $dependencias = $this->main->getListSelect('dependencia', "dependencia.nombre_dependencia,estado.descripcion, dependencia.id_dependencia, dependencia.id_estado", ["dependencia.nombre_dependencia"=> 'ASC']);
        $data['dependencias'] = json_encode($dependencias);

        $this->load->view('normal/dependencia/index', $data, FALSE);
    }

    public function registrar(){

        $this->form_validation->set_rules('dependencia', lang('dependencia'), 'trim|required|mb_strtoupper');
        //$this->form_validation->set_rules('detalle', lang('detalle'), 'trim|required');
        //$this->form_validation->set_rules('estado', lang('estado'), 'required');

        if ($this->form_validation->run()) {

            //$registro['detalle']                            = set_value('detalle');
            $registro['id_estado']                          = 1;

            $registro['id_usuario'] = $this->session->sistema->id_usuario;
            $registro['fecha_registro'] = date('Y-m-d H:i:s');

            $id = set_value('id_dependencia');

            if ($id == 0) {
                $registro['nombre_dependencia']                 = set_value('dependencia');

                $this->main->insert('dependencia', $registro);
                $this->session->set_flashdata('success', lang('registro.dependencia'));
            } else {
                $registro['nombre_area']                 = set_value('area');
                $registro['usuario_modificacion'] = $this->session->sistema->nombre_completo;
                $registro['fecha_modificacion'] = date('Y-m-d H:i:s');
                $this->main->update('dependencia', $registro, ['id_dependencia' => $id]);
                $this->session->set_flashdata('success', lang('dependencia.modificado'));
            }
            redirect('dependencias');
        }
    }
    public function search_dependencias()
    {

      $json = [];

      $this->load->database();

      if(!empty($this->input->get("q"))){
            //print_r($this->input->get("q"));
          $cad=mb_strtoupper($this->input->get('q'),'UTF-8');
          if($cad != ''){
            $where['nombre_dependencia like '] = "'%'.$cad.'%'";
          }

          $where['id_estado'] = 1;
          //$this->db->like('nombre_area',  $cad);
          //  $this->db->like('nombre_area', $cad, 'both', false);
          //$query = $this->main->getSelect('area','id_area as id, nombre_area as text',$where);

          $consulta ="SELECT id_dependencia as id, nombre_dependencia as text FROM dependencia WHERE nombre_dependencia LIKE '%$cad%' AND id_estado = '1'";
          $query = $this->db->query($consulta);
          $json = $query->result();

        }

      echo json_encode($json);
    }
}
