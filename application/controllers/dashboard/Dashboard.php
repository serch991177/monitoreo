<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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

        $search_value = strtoupper($search_value);

        $columna = $_GET['order'][0]['column'];
        $dir = $_GET['order'][0]['dir'];

        if ($columna != '') {
            switch ($columna) {
                case '1':
                    $orden = 't.tema ' . $dir;
                    break;
                case '2':
                    $orden = 'canti_notas ' . $dir;
                    break;
                case '3':
                    $orden = 'positivos ' . $dir;
                    break;
                case '4':
                    $orden = 'negativos ' . $dir;
                    break;
                case '5':
                    $orden = 'neutros ' . $dir;
                    break;
                default:
                    $orden = 't.tema ' . 'ASC';
                    break;
            }
        } else {
            $orden = 't.tema  = ASC';
        }

        $hoy = date('Y-m-d');
        //$hoy = '2022-06-13';

        $where = "t.id_estado = 1 and nota.id_estado = 1";
        $where2 = "";

        if ($filter_ini != '' && $filter_fin != '') {
            $where .= " AND nota.fecha_registro BETWEEN '" . $filter_ini . " 00:00'" . " AND '" . $filter_fin . " 23:59'";
            $where2 .= " AND n.fecha_registro BETWEEN '" . $filter_ini . " 00:00'" . " AND '" . $filter_fin . " 23:59'";
        } else {
            if ($filter_ini != '') {
                $where .= " AND nota.fecha_registro BETWEEN '" . $filter_ini . " 00:00'" . " AND '" . $filter_ini . " 23:59'";
                $where2 .= " AND n.fecha_registro BETWEEN '" . $filter_ini . " 00:00'" . " AND '" . $filter_ini . " 23:59'";
            } else {
                $where .= " AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";
                $where2 .= " AND n.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";
            }
        }

        if ($search_value != '') {
            $where .= " AND t.tema LIKE '%$search_value%'";
        }

        $query = "select distinct t.id_tema from tema t LEFT JOIN nota ON nota.id_tema = t.id_tema WHERE " . $where;
        $registros = $this->db->query($query)->result();

        $contador = count($registros);

        if ($start != 0) {
            $cad = " LIMIT " . $length . " OFFSET " . $start;
        } else {
            $cad = " LIMIT " . $length;
        }

        $sq = "SELECT distinct t.id_tema, t.tema, (SELECT COUNT(n.id_nota) FROM nota n LEFT JOIN detalle_medio dm ON n.id_nota = dm.id_nota WHERE id_tema = t.id_tema and id_estado = 1" . $where2 . ")canti_notas, 
        (SELECT distinct COUNT(n.id_nota) FROM nota n LEFT JOIN detalle_medio dm ON n.id_nota = dm.id_nota WHERE n.id_tema = t.id_tema and dm.id_tendencia = 1 and n.id_estado = 1" . $where2 . ")positivos,
        (SELECT distinct COUNT(n.id_nota) FROM nota n LEFT JOIN detalle_medio dm ON n.id_nota = dm.id_nota WHERE n.id_tema = t.id_tema and dm.id_tendencia = 2 and n.id_estado = 1" . $where2 . ")negativos,
        (SELECT distinct COUNT(n.id_nota) FROM nota n LEFT JOIN detalle_medio dm ON n.id_nota = dm.id_nota WHERE n.id_tema = t.id_tema and dm.id_tendencia = 3 and n.id_estado = 1" . $where2 . ")neutros
        FROM tema t LEFT JOIN nota ON nota.id_tema = t.id_tema WHERE " . $where . " ORDER BY " . $orden . $cad;

        $temas = $this->db->query($sq)->result();

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
        $hoy = date('Y-m-d');
        //$hoy = '2022-06-13';

        $sq = "SELECT distinct t.id_tema, t.tema, (SELECT distinct COUNT(n.id_nota) FROM nota n LEFT JOIN detalle_medio dm ON n.id_nota = dm.id_nota WHERE id_tema = t.id_tema and id_estado = 1)canti_notas, 
        (SELECT distinct COUNT(n.id_nota) FROM nota n LEFT JOIN detalle_medio dm ON n.id_nota = dm.id_nota WHERE n.id_tema = t.id_tema and dm.id_tendencia = 1 and n.id_estado = 1 AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59')positivos,
        (SELECT distinct COUNT(n.id_nota) FROM nota n LEFT JOIN detalle_medio dm ON n.id_nota = dm.id_nota WHERE n.id_tema = t.id_tema and dm.id_tendencia = 2 and n.id_estado = 1 AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59')negativos,
        (SELECT distinct COUNT(n.id_nota) FROM nota n LEFT JOIN detalle_medio dm ON n.id_nota = dm.id_nota WHERE n.id_tema = t.id_tema and dm.id_tendencia = 3 and n.id_estado = 1 AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59')neutros
        FROM tema t LEFT JOIN nota ON nota.id_tema = t.id_tema WHERE t.id_estado = 1 AND nota.id_estado = 1 AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";

        $data['temas'] = $this->db->query($sq)->result();

        $this->load->view('dashboard/dashboard', $data, FALSE);
    }

    public function obtain_notas()
    {

        $id_tema = set_value('id_tema');
        $fecha_ini = set_value('fecha_ini');
        $fecha_fin = set_value('fecha_fin');

        $where = "nota.id_tema = " . $id_tema . " AND nota.id_estado = 1";
         $hoy = date('Y-m-d');
         //$hoy = '2022-06-13';

        if ($fecha_ini != '' && $fecha_fin != '') {
            $where .= " AND nota.fecha_registro BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_fin . " 23:59'";
        } else {
            if ($fecha_ini != '') {
                $where .= " AND nota.fecha_registro BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_ini . " 23:59'";
            } else {
                $where .= " AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";
            }
        }

        $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
        $this->db->join('detalle_medio', 'detalle_medio.id_nota = nota.id_nota', 'left');
        $this->db->join('dependencia', 'nota.id_dependencia= dependencia.id_dependencia', 'left');
        $this->db->join('tendencia', 'tendencia.id_tendencia=detalle_medio.id_tendencia', 'left');
        $this->db->join('recurso', 'detalle_medio.id_recurso= recurso.id_recurso', 'left');
        $this->db->join('tipo_noticia', 'tipo_noticia.id_tipo_noticia= detalle_medio.id_tipo_noticia', 'left');
        $this->db->join('turno', 'turno.id_turno=detalle_medio.id_turno', 'left');
        $notas = $this->main->getListSelectWD('nota', "nota.id_nota, tema.tema, dependencia.nombre_dependencia,  to_char(nota.fecha_registro,'DD/MM/YYYY')as fecha_registro_nota, recurso.nombre, tendencia.nombre_tendencia, tipo_noticia.tipo_noticia, turno.turno, nota.detalle", ['id_nota' => 'ASC'], $where);

        $data['notas'] = $notas;

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'response' => $data
            ]));
    }

    public function impresion()
    {

        $fecha_ini = set_value("f_ini");
        $fecha_fin = set_value("f_fin");
        $id_tema = set_value("id_tema");

        $where = "nota.id_tema = " . $id_tema . " AND nota.id_estado = 1";
        //$hoy = date('Y-m-d');
        $hoy = '2022-06-13';

        if ($fecha_ini != '' && $fecha_fin != '') {
            $where .= " AND nota.fecha_registro BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_fin . " 23:59'";
        } else {
            if ($fecha_ini != '') {
                $where .= " AND nota.fecha_registro BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_ini . " 23:59'";
            } else {
                $where .= " AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";
            }
        }

        $data['tema'] = $this->main->getField('tema','tema',['id_tema'=>$id_tema]);

        $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
        $this->db->join('detalle_medio', 'detalle_medio.id_nota = nota.id_nota', 'left');
        $this->db->join('dependencia', 'nota.id_dependencia= dependencia.id_dependencia', 'left');
        $this->db->join('tendencia', 'tendencia.id_tendencia=detalle_medio.id_tendencia', 'left');
        $this->db->join('recurso', 'detalle_medio.id_recurso= recurso.id_recurso', 'left');
        $this->db->join('tipo_noticia', 'tipo_noticia.id_tipo_noticia= detalle_medio.id_tipo_noticia', 'left');
        $this->db->join('turno', 'turno.id_turno=detalle_medio.id_turno', 'left');
        $notas = $this->main->getListSelectWD('nota', "ROW_NUMBER() OVER (ORDER BY (nota.id_nota)ASC) as row, nota.id_nota, tema.tema, dependencia.nombre_dependencia,  to_char(nota.fecha_registro,'DD/MM/YYYY')as fecha_registro_nota, recurso.nombre, tendencia.nombre_tendencia, tipo_noticia.tipo_noticia, turno.turno, nota.detalle", ['id_nota' => 'ASC'], $where);

        $data['notas'] = $notas;

        $this->load->view('dashboard/impresion', $data, FALSE);
    }

    public function impresion_posis(){

        $fecha_ini = set_value("f_ini");
        $fecha_fin = set_value("f_fin");
        $id_tema = set_value("id_tema");

        $where = "nota.id_tema = " . $id_tema . " AND nota.id_estado = 1 AND detalle_medio.id_tendencia = 1";
        $hoy = date('Y-m-d');
        //$hoy = '2022-06-13';

        if ($fecha_ini != '' && $fecha_fin != '') {
            $where .= " AND nota.fecha_registro BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_fin . " 23:59'";
        } else {
            if ($fecha_ini != '') {
                $where .= " AND nota.fecha_registro BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_ini . " 23:59'";
            } else {
                $where .= " AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";
            }
        }

        $data['tema'] = $this->main->getField('tema','tema',['id_tema'=>$id_tema]);

        $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
        $this->db->join('detalle_medio', 'detalle_medio.id_nota = nota.id_nota', 'left');
        $this->db->join('dependencia', 'nota.id_dependencia= dependencia.id_dependencia', 'left');
        $this->db->join('tendencia', 'tendencia.id_tendencia=detalle_medio.id_tendencia', 'left');
        $this->db->join('recurso', 'detalle_medio.id_recurso= recurso.id_recurso', 'left');
        $this->db->join('tipo_noticia', 'tipo_noticia.id_tipo_noticia= detalle_medio.id_tipo_noticia', 'left');
        $this->db->join('turno', 'turno.id_turno=detalle_medio.id_turno', 'left');
        $notas = $this->main->getListSelectWD('nota', "ROW_NUMBER() OVER (ORDER BY (nota.id_nota)ASC) as row, nota.id_nota, tema.tema, dependencia.nombre_dependencia,  to_char(nota.fecha_registro,'DD/MM/YYYY')as fecha_registro_nota, recurso.nombre, tendencia.nombre_tendencia, tipo_noticia.tipo_noticia, turno.turno, nota.detalle", ['id_nota' => 'ASC'], $where);

        $data['notas'] = $notas;

        $this->load->view('dashboard/impresion', $data, FALSE);

    }

    public function impresion_negas(){

        $fecha_ini = set_value("f_ini");
        $fecha_fin = set_value("f_fin");
        $id_tema = set_value("id_tema");

        $where = "nota.id_tema = " . $id_tema . " AND nota.id_estado = 1 AND detalle_medio.id_tendencia = 2";
        $hoy = date('Y-m-d');
        //$hoy = '2022-06-13';

        if ($fecha_ini != '' && $fecha_fin != '') {
            $where .= " AND nota.fecha_registro BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_fin . " 23:59'";
        } else {
            if ($fecha_ini != '') {
                $where .= " AND nota.fecha_registro BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_ini . " 23:59'";
            } else {
                $where .= " AND nota.fecha_registro BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";
            }
        }

        $data['tema'] = $this->main->getField('tema','tema',['id_tema'=>$id_tema]);

        $this->db->join('tema', 'tema.id_tema = nota.id_tema', 'left');
        $this->db->join('detalle_medio', 'detalle_medio.id_nota = nota.id_nota', 'left');
        $this->db->join('dependencia', 'nota.id_dependencia= dependencia.id_dependencia', 'left');
        $this->db->join('tendencia', 'tendencia.id_tendencia=detalle_medio.id_tendencia', 'left');
        $this->db->join('recurso', 'detalle_medio.id_recurso= recurso.id_recurso', 'left');
        $this->db->join('tipo_noticia', 'tipo_noticia.id_tipo_noticia= detalle_medio.id_tipo_noticia', 'left');
        $this->db->join('turno', 'turno.id_turno=detalle_medio.id_turno', 'left');
        $notas = $this->main->getListSelectWD('nota', "ROW_NUMBER() OVER (ORDER BY (nota.id_nota)ASC) as row, nota.id_nota, tema.tema, dependencia.nombre_dependencia,  to_char(nota.fecha_registro,'DD/MM/YYYY')as fecha_registro_nota, recurso.nombre, tendencia.nombre_tendencia, tipo_noticia.tipo_noticia, turno.turno, nota.detalle", ['id_nota' => 'ASC'], $where);

        $data['notas'] = $notas;

        $this->load->view('dashboard/impresion', $data, FALSE);
    }
}
