<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medio extends CI_Controller
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
                    $orden['recurso.nombre'] = $dir;
                    break;
                case '2':
                    $orden['recurso.detalle'] = $dir;
                    break;
                case '3':
                    $orden['estado.descripcion'] = $dir;
                    break;
                default:
                    $orden['medio.nombre_medio'] = $dir;
                    break;
            }
        } else {
            $orden['recurso.nombre'] = 'ASC';
        }

        $search_value = strtoupper($search_value);

        if ($search_value != '') {
            $this->db->like('recurso.detalle', $search_value, 'both', false);
            $this->db->or_like('recurso.detalle', $search_value, 'both', false);
            $this->db->or_like('estado.descripcion', $search_value, 'both', false);
        }

        $this->db->join('estado', 'recurso.id_estado = estado.id_estado', 'left');
        $contador = $this->main->total('recurso');

        if ($search_value != '') {

            $this->db->like('medio.nombre_medio', $search_value, 'both', false);
            $this->db->or_like('recurso.nombre', $search_value, 'both', false);
            $this->db->or_like('estado.descripcion', $search_value, 'both', false);
        }


        $this->db->join('medio', 'medio.id_medio = recurso.id_medio', 'left');
        $this->db->join('estado', 'estado.id_estado = recurso.id_estado', 'left');
        $medios = $this->main->getListSelect('recurso', "medio.nombre_medio,recurso.nombre,recurso.detalle, estado.descripcion, medio.id_medio,recurso.id_recurso, recurso.id_estado", $orden, null, $length, $start);

        $data = $medios;

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
        $tipo = $this->main->getListSelect('medio', 'id_medio,nombre_medio', ['nombre_medio' => 'ASC']);
        $data['tipos'] = $this->main->dropdown($tipo, 'SELECCIONAR');
        $this->db->join('medio', 'medio.id_medio = recurso.id_medio', 'left');
        $this->db->join('estado', 'estado.id_estado = recurso.id_estado', 'left');
        $medios = $this->main->getListSelect('recurso', "medio.nombre_medio, recurso.detalle,recurso.nombre, estado.descripcion, medio.id_medio,recurso.id_recurso, recurso.id_estado", ["recurso.nombre"=> 'ASC']);
        $data['medios'] = json_encode($medios);

        $this->load->view('normal/medio/index', $data, FALSE);
    }

    public function registrar(){

        $this->form_validation->set_rules('medio', lang('medio'), 'trim|required|mb_strtoupper');
        $this->form_validation->set_rules('detalle', lang('detalle'), 'trim|required');
        $this->form_validation->set_rules('tipo', lang('tipo'), 'required');
        $this->form_validation->set_rules('estado', lang('estado'), 'required');

        if ($this->form_validation->run()) {

            $registro['detalle']                         = set_value('detalle');
            $registro['id_estado']                       = set_value('estado');
            $registro['id_medio']                          = set_value('tipo');

            $registro['id_usuario'] = $this->session->sistema->id_usuario;
            $registro['fecha_registro'] = date('Y-m-d H:i:s');
            $id = set_value('id_recurso');

            if ($id == 0) {
              $tipo_medio = $this->main->getSelect('medio','nombre_medio',['id_medio'=>$registro['id_medio']]);
              $nombre=  set_value('medio').'-'.$tipo_medio->nombre_medio;
              /*print_r($nombre);
              die();*/
              $registro['nombre']                = $nombre;


                $this->main->insert('recurso', $registro);
                $this->session->set_flashdata('success', lang('registro.dependencia'));
            } else {
              $tipo_medio = $this->main->getSelect('medio','nombre_medio',['id_medio'=>$registro['id_medio']]);

                $registro['nombre']        = set_value('medio').'-'.$tipo_medio->nombre_medio;
                //$registro['nombre_tipo']  =$tipo_medio;
                $registro['usuario_modificacion'] = $this->session->sistema->nombre_completo;
                $registro['fecha_modificacion'] = date('Y-m-d H:i:s');
                $this->main->update('recurso', $registro, ['id_recurso' => $id]);
                $this->session->set_flashdata('success', lang('medio.modificado'));
            }
            redirect('medios');
        }
        else{

            $this->session->set_flashdata('alert', validation_errors('<div class="error"><i class="las la-exclamation-triangle la-2x"></i>', '</div>'));
            
            redirect('medios');
        }
    }
}
