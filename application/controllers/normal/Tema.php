<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tema extends CI_Controller
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
                    $orden['tema.tema'] = $dir;
                    break;

                case '2':
                    $orden['estado.descripcion'] = $dir;
                    break;
                default:
                    $orden['tema.tema'] = $dir;
                    break;
            }
        } else {
            $orden['tema.tema'] = 'ASC';
        }

        $search_value = strtoupper($search_value);

        if ($search_value != '') {
            $this->db->like('tema.tema', $search_value, 'both', false);
            $this->db->or_like('estado.descripcion', $search_value, 'both', false);
        }

        $this->db->join('estado', 'tema.id_estado = estado.id_estado', 'left');
        $contador = $this->main->total('tema');

        if ($search_value != '') {

            $this->db->like('tema.tema', $search_value, 'both', false);

            $this->db->or_like('estado.descripcion', $search_value, 'both', false);
        }

        $this->db->join('estado', 'estado.id_estado = tema.id_estado', 'left');
        $temas = $this->main->getListSelect('tema', "tema.tema, estado.descripcion, tema.id_tema, tema.id_estado", $orden, null, $length, $start);

        $data = $temas;

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

        $this->db->join('estado', 'estado.id_estado = tema.id_estado', 'left');
        $temas = $this->main->getListSelect('tema', "tema.tema, estado.descripcion, tema.id_tema, tema.id_estado", ["tema.tema"=> 'ASC']);
        $data['temas'] = json_encode($temas);

        $this->load->view('normal/tema/index', $data, FALSE);
    }

    public function registrar(){

        $this->form_validation->set_rules('tema', lang('tema'), 'trim|required|mb_strtoupper');

        $this->form_validation->set_rules('estado', lang('estado'), 'required');

        if ($this->form_validation->run()) {


            $registro['id_estado']                          = set_value('estado');


            $registro['id_usuario'] = $this->session->sistema->id_usuario;
            $registro['fecha_registro'] = date('Y-m-d H:i:s');
            $id = set_value('id_tema');

            if ($id == 0) {
                  $registro['tema']                          = set_value('tema');

                $this->main->insert('tema', $registro);
                $this->session->set_flashdata('success', lang('registro.tema'));
            } else {
                $registro['tema']                          = set_value('tema');
                $registro['usuario_modificacion'] = $this->session->sistema->nombre_completo;
                $registro['fecha_modificacion'] = date('Y-m-d H:i:s');
                $this->main->update('tema', $registro, ['id_tema' => $id]);
                $this->session->set_flashdata('success', lang('tema.modificada'));
            }
            redirect('temas');
        }
    }
    public function search_temas(){
        $json = [];

        $this->load->database();

        if(!empty($this->input->get("q"))){

                $cad=mb_strtoupper($this->input->get('q'),'UTF-8');

                $this->db->like('tema',  $cad);
                $query = $this->db->select('id_tema as id, tema as text')

                            ->where('id_estado','1')
                            ->get("tema");
                $json = $query->result();
            }

        echo json_encode($json);
    }
  
    public function actualizarEstadoTodos(){
        $estado = $this->input->post('estado');
        $nuevoEstado = ($estado === 'habilitar') ? 1 : 0;
        $this->db->set('id_estado', $nuevoEstado);
        $this->db->update('tema');
        echo json_encode(['success' => true]);
    }
}
