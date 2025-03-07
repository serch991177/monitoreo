<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

    public function index($draw = 1)
    {
        $where = null;
        $start = $this->input->get('start');
        $draw = $this->input->get('draw');
        $length = $this->input->get('length');
        $search_value = $_GET['search']['value'];

        $filter_ini = $_GET['filter_ini'];
        $filter_fin = $_GET['filter_fin'];
        $filter_medio = $_GET['filter_medio'];
        $filter_tendencia = $_GET['filter_tendencia'];

        $search_value = strtoupper($search_value);

        $columna = $_GET['order'][0]['column'];
        $dir = $_GET['order'][0]['dir'];

        if ($columna != '') {
            switch ($columna) {
                case '1':
                    $orden = ['tema '=>$dir];
                    break;
                case '2':
                    $orden = ['detalle'=> $dir];
                    break;
                case '3':
                    $orden = ['turno'=>$dir];
                    break;
                case '4':
                    $orden = ['nota.fecha_registro' => $dir];
                    break;
                case '5':
                    $orden = ['nombre_tendencia' => $dir];
                    break;
                default:
                    $orden = ['tema'=> 'ASC'];
                    break;
            }
        } else {
            $orden = ['tema' =>'ASC'];
        }

        $hoy = date('Y-m-d');
        //$hoy = '2022-09-07';

        $where = "tema.id_estado = 1 and nota.id_estado = 1";

        if ($filter_ini != '' && $filter_fin != '') {
            $where .= " AND nota.fecha_registro BETWEEN '" . $filter_ini . " 00:00'" . " AND '" . $filter_fin . " 23:59'";
        } else {
            if ($filter_ini != '') {
                $where .= " AND nota.fecha_registro BETWEEN '" . $filter_ini . " 00:00'" . " AND '" . $filter_ini . " 23:59'";
            } else {
                $where .= " AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";
            }
        }

        if($filter_medio != '')
        {
            $where .= " AND detalle_medio.id_recurso = ".$filter_medio;
        }

        if($filter_tendencia != '')
        {
            $where .= " AND detalle_medio.id_tendencia = ".$filter_tendencia;
        }

        $select = "tema, nombre_tendencia, nota.detalle, nota.fecha_registro, turno, recurso.nombre,  to_char(nota.fecha_registro,'DD/MM/YYYY') as fecha";

        if ($search_value != '') {
            $this->db->group_start();
            $this->db->like('recurso.nombre', $search_value, 'both', false);
            $this->db->or_like('tema', $search_value, 'both', false);
            $this->db->or_like('turno', $search_value, 'both', false);
            $this->db->or_like('turno', $search_value, 'both', false);
            $this->db->or_like('nombre_tendencia', $search_value, 'both', false);
            $this->db->group_end();
        }

        $this->db->join('tendencia', 'tendencia.id_tendencia = detalle_medio.id_tendencia', 'left');
        $this->db->join('nota', 'nota.id_nota = detalle_medio.id_nota', 'left');;
        $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
        $this->db->join('turno', 'turno.id_turno = detalle_medio.id_turno', 'left');
        $this->db->join('recurso', 'recurso.id_recurso = detalle_medio.id_recurso', 'left');
        $total = $this->main->getListSelect('detalle_medio', $select, $orden, $where);

        
        if ($search_value != '') {
            $this->db->group_start();
            $this->db->like('recurso.nombre', $search_value, 'both', false);
            $this->db->or_like('tema', $search_value, 'both', false);
            $this->db->or_like('turno', $search_value, 'both', false);
            $this->db->or_like('nombre_tendencia', $search_value, 'both', false);
            $this->db->group_end();
        }        
        
        $this->db->join('tendencia', 'tendencia.id_tendencia = detalle_medio.id_tendencia', 'left');
        $this->db->join('nota', 'nota.id_nota = detalle_medio.id_nota', 'left');;
        $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
        $this->db->join('turno', 'turno.id_turno = detalle_medio.id_turno', 'left');
        $this->db->join('recurso', 'recurso.id_recurso = detalle_medio.id_recurso', 'left');
        $reporte = $this->main->getListSelect('detalle_medio', $select, $orden, $where,$length, $start);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(
                json_encode([
                    'draw' => $draw,
                    'recordsTotal' => count($total),
                    'recordsFiltered' => count($total),
                    'data' => $reporte
                ])
            );
    }

    public function lista()
    {
        $hoy = date('Y-m-d');
        //$hoy = '2022-09-07';

        $select = "tema, nombre_tendencia, nota.detalle, nota.fecha_registro, turno, recurso.nombre, to_char(nota.fecha_registro,'DD/MM/YYYY') as fecha";

        $where = "tema.id_estado = 1 and nota.id_estado = 1 AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";

        $this->db->join('tendencia', 'tendencia.id_tendencia = detalle_medio.id_tendencia', 'left');
        $this->db->join('nota', 'nota.id_nota = detalle_medio.id_nota', 'left');;
        $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
        $this->db->join('turno', 'turno.id_turno = detalle_medio.id_turno', 'left');
        $this->db->join('recurso', 'recurso.id_recurso = detalle_medio.id_recurso', 'left');
        $reporte = $this->main->getListSelect('detalle_medio', $select, ['tema'=>'ASC'], $where);

        $data['reporte'] = json_encode($reporte);

        $medios = $this->main->getListSelect('recurso', 'id_recurso, nombre', ['nombre' => 'ASC']);
        $data['medios'] = $this->main->dropdown($medios, 'TODOS LOS MEDIOS');

        $tendencias = $this->main->getListSelect('tendencia', 'id_tendencia, nombre_tendencia', ['nombre_tendencia' => 'ASC']);
        $data['tendencias'] = $this->main->dropdown($tendencias, 'TODAS');


        $this->load->view('dashboard/reporte', $data, FALSE);
    }


}