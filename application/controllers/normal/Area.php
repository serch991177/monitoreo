<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Area extends CI_Controller
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
                    $orden['area.nombre_area'] = $dir;
                    break;
                case '2':
                    $orden['area.detalle'] = $dir;
                    break;
                case '3':
                    $orden['estado.descripcion'] = $dir;
                    break;
                default:
                    $orden['area.nombre_area'] = $dir;
                    break;
            }
        } else {
            $orden['area.nombre_area'] = 'ASC';
        }

        $search_value = strtoupper($search_value);

        if ($search_value != '') {
            $this->db->like('area.nombre_area', $search_value, 'both', false);
            $this->db->or_like('area.detalle', $search_value, 'both', false);
            $this->db->or_like('estado.descripcion', $search_value, 'both', false);
        }

        $this->db->join('estado', 'area.id_estado = estado.id_estado', 'left');
        $contador = $this->main->total('area');

        if ($search_value != '') {

            $this->db->like('area.nombre_area', $search_value, 'both', false);
            $this->db->or_like('area.detalle', $search_value, 'both', false);
            $this->db->or_like('estado.descripcion', $search_value, 'both', false);
        }

        $this->db->join('estado', 'area.id_estado = estado.id_estado', 'left');
        $areas = $this->main->getListSelect('area', "area.nombre_area, area.detalle, estado.descripcion, area.id_area, area.id_estado", $orden, null, $length, $start);

        $data = $areas;

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

        $this->db->join('estado', 'area.id_estado = estado.id_estado', 'left');
        $areas = $this->main->getListSelect('area', "area.nombre_area, area.detalle, estado.descripcion, area.id_area, area.id_estado", ["area.nombre_area" => 'ASC']);
        $data['areas'] = json_encode($areas);

        $this->load->view('normal/area/index', $data, FALSE);
    }
    public function registrar(){

        $this->form_validation->set_rules('area', lang('area'), 'trim|required|mb_strtoupper');
        $this->form_validation->set_rules('detalle', lang('detalle'), 'trim|required');
        $this->form_validation->set_rules('estado', lang('estado'), 'required');

        if ($this->form_validation->run()) {

            $registro['detalle']                            = set_value('detalle');
            $registro['id_estado']                          = set_value('estado');

            $registro['id_usuario'] = $this->session->sistema->id_usuario;
            $registro['fecha_registro'] = date('Y-m-d H:i:s');

            $id = set_value('id_area');

            if ($id == 0) {
                $registro['nombre_area']                 = set_value('area');

                $this->main->insert('area', $registro);
                $this->session->set_flashdata('success', lang('registro.area'));
            } else {
                $registro['nombre_area']                 = set_value('area');
                $registro['usuario_modificacion'] = $this->session->sistema->nombre_completo;
                $registro['fecha_modificacion'] = date('Y-m-d H:i:s');
                $this->main->update('area', $registro, ['id_area' => $id]);
                $this->session->set_flashdata('success', lang('area.modificado'));
            }
            redirect('areas');
        }
    }
    public function search_areas()
    {

      $json = [];

    	$this->load->database();

    	if(!empty($this->input->get("q"))){
            //print_r($this->input->get("q"));
    			$cad=mb_strtoupper($this->input->get('q'),'UTF-8');
          if($cad != ''){
            $where['area.nombre_area like '] = "'%'.$cad.'%'";
          }

          $where['area.id_estado'] = 1;
    			//$this->db->like('nombre_area',  $cad);
          //  $this->db->like('nombre_area', $cad, 'both', false);
          //$query = $this->main->getSelect('area','id_area as id, nombre_area as text',$where);

          $consulta ="SELECT id_area as id, nombre_area as text FROM area WHERE nombre_area LIKE '%$cad%' AND id_estado = '1'";
          $query = $this->db->query($consulta);
          $json = $query->result();

    		}

      echo json_encode($json);
    }
}
