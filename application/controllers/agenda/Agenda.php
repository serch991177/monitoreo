<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agenda extends CI_Controller
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

        //$orden = 'motivo_espacio ASC';

        if ($columna != '') {
            switch ($columna) {
                case '1':
                    $orden = 'motivo_espacio ' . $dir;
                    break;
                case '2':
                    $orden = 'nombre_completo ' . $dir;
                    break;
                default:
                    $orden = 'motivo_espacio ' . $dir;
                    break;
            }
        } else {
            $orden = 'motivo_espacio ASC';
        }

        $hoy = date('Y-m-d');
        //$hoy = '2022-06-13';

        $where = "espacio.id_estado = 1 and agenda.id_estado = 1";

        if ($filter_ini != '' && $filter_fin != '') {
            $where .= " AND agenda.fecha BETWEEN '" . $filter_ini . " 00:00'" . " AND '" . $filter_fin . " 23:59'";
        } else {
            if ($filter_ini != '') {
                $where .= " AND agenda.fecha BETWEEN '" . $filter_ini . " 00:00'" . " AND '" . $filter_ini . " 23:59'";
            } else {
                $where .= " AND agenda.fecha BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";
            }
        }

        if ($search_value != '') {
            $where .= " AND (motivo_espacio LIKE '%$search_value%' OR nombre_completo LIKE '%$search_value%')";
        }

        $query = "select distinct motivo_espacio, nombre_completo, espacio.id_espacio from espacio LEFT JOIN agenda ON espacio.id_espacio = agenda.id_espacio LEFT JOIN interlocutor ON interlocutor.id_interlocutor = espacio.id_interlocutor WHERE " . $where;
        $registros = $this->db->query($query)->result();

        $contador = count($registros);

        if ($start != 0) {
            $cad = " LIMIT " . $length . " OFFSET " . $start;
        } else {
            $cad = " LIMIT " . $length;
        }

        $sq = "select distinct motivo_espacio, nombre_completo, espacio.id_espacio from espacio LEFT JOIN agenda ON espacio.id_espacio = agenda.id_espacio LEFT JOIN interlocutor ON interlocutor.id_interlocutor = espacio.id_interlocutor 
        WHERE " . $where . " ORDER BY " . $orden . $cad;

        $espacios = $this->db->query($sq)->result();

        $data = $espacios;

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

        $sq = "select distinct motivo_espacio, nombre_completo, espacio.id_espacio from espacio LEFT JOIN agenda ON espacio.id_espacio = agenda.id_espacio LEFT JOIN interlocutor ON interlocutor.id_interlocutor = espacio.id_interlocutor 
        WHERE espacio.id_estado = 1 and agenda.id_estado = 1 AND agenda.fecha BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";

        $data['espacios'] = $this->db->query($sq)->result();

        $medios = $this->main->getListSelect('recurso', 'id_recurso, nombre', ['nombre' => 'ASC']);
        $data['medios'] = $this->main->dropdown($medios, 'SELECCIONE EL MEDIO');

        $interlocutores = $this->main->getListSelect('interlocutor', 'id_interlocutor, nombre_completo', ['nombre_completo' => 'ASC']);
        $data['interlocutores'] = $this->main->dropdown($interlocutores, 'SELECCIONE EL INTERLOCUTOR');

        $programas = $this->main->getListSelect('programa', 'id_programa, nombre_programa', ['nombre_programa' => 'ASC']);
        $data['programas'] = $this->main->dropdown($programas, 'SELECCIONE EL PROGRAMA');

        $horas = $this->main->getListSelect('hora', "to_char(hora,'HH24:MI')AS hora_id, to_char(hora,'HH24:MI')AS hora_format", ['hora_format' => 'ASC']);
        $data['horas'] = $this->main->dropdown($horas, 'SELECCIONE LA HORA');

        $data['lugar'] = ['' => 'SELECCIONAR', 'SET' => 'SET', 'UNIDAD MOVIL' => 'UNIDAD MOVIL'];

        $this->load->view('agenda/agenda', $data, FALSE);
    }

    public function programas()
    {
        $programas = $this->main->getListSelect('programa', "programa.nombre_programa, programa.id_programa, recurso.nombre", ['programa.nombre_programa' => 'ASC'], ['programa.id_estado' => 1], null, null, ['recurso' => 'id_recurso']);

        $data['resultado'] = json_encode($programas);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'response' => $data
            ]));
    }

    public function registrar_programa()
    {
        $programa = $_POST['programa'];
        $id_recurso = $_POST['id_recurso'];

        $existe = $this->main->get('programa', ['id_recurso' => $id_recurso, 'nombre_programa' => $programa]);

        if (!$existe) {
            $registro['nombre_programa'] = strtoupper(trim($programa));
            $registro['fecha_registro'] = date('Y-m-d H:i:s');
            $registro['id_estado'] = 1;
            $registro['id_usuario'] =  $this->session->sistema->id_usuario;
            $registro['id_recurso'] = $id_recurso;

            $this->main->insert('programa', $registro);

            $status = true;
        }
        else{
            $status = false;
        }

        $programas = $this->main->getListSelect('programa', "programa.nombre_programa, programa.id_programa, recurso.nombre", ['programa.nombre_programa' => 'ASC'], ['programa.id_estado' => 1], null, null, ['recurso' => 'id_recurso']);
        $info['data'] = $programas;

        $programas = $this->main->getListSelect('programa', 'id_programa, nombre_programa', ['nombre_programa' => 'ASC']);
        $info['programas'] = $this->main->dropdown($programas);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => $status,
                'response' => $info
            ]));
    }

    public function eliminar_programa(){
     
        $id_programa = $_POST['id_prog'];

        $actualizacion['id_estado'] = 2;

        $this->main->update('programa', $actualizacion, ['id_programa' => $id_programa]);
        
        $programas = $this->main->getListSelect('programa', "programa.nombre_programa, programa.id_programa, recurso.nombre", ['programa.nombre_programa' => 'ASC'], ['programa.id_estado' => 1], null, null, ['recurso' => 'id_recurso']);
        $info['data'] = $programas;


        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'response' => $info
            ]));
    }

    public function interlocutores()
    {
        $interlocutores = $this->main->getListSelect('interlocutor', "interlocutor.nombre_completo, interlocutor.id_interlocutor, interlocutor.cargo", ['interlocutor.nombre_completo' => 'ASC'], ['interlocutor.id_estado' => 1]);

        $data['resultado'] = json_encode($interlocutores);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'response' => $data
            ]));
    }

    public function registrar_interlocutor()
    {
        $interlocutor = $_POST['interlocutor'];
        $cargo = $_POST['cargo'];

        $existe = $this->main->get('interlocutor', ['nombre_completo' => $interlocutor, 'cargo' => $cargo]);

        if (!$existe) {
            $registro['nombre_completo'] = strtoupper(trim($interlocutor));
            $registro['cargo'] = strtoupper(trim($cargo));
            $registro['fecha_registro'] = date('Y-m-d H:i:s');
            $registro['id_estado'] = 1;
            $registro['id_usuario'] =  $this->session->sistema->id_usuario;

            $this->main->insert('interlocutor', $registro);

            $status = true;
        }
        else{
            $status = false;
        }

        $interlocutores = $this->main->getListSelect('interlocutor', "interlocutor.nombre_completo, interlocutor.id_interlocutor, interlocutor.cargo", ['interlocutor.nombre_completo' => 'ASC'], ['interlocutor.id_estado' => 1]);
        $info['data'] = $interlocutores;

        $combo = $this->main->getListSelect('interlocutor', 'id_interlocutor, nombre_completo', ['nombre_completo' => 'ASC']);
        $info['interlocutores'] = $this->main->dropdown($combo);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => $status,
                'response' => $info
            ]));
    }

    public function eliminar_interlocutor(){
     
        $id_interlocutor = $_POST['id_inter'];

        $actualizacion['id_estado'] = 2;

        $this->main->update('interlocutor', $actualizacion, ['id_interlocutor' => $id_interlocutor]);
        
        $interlocutores = $this->main->getListSelect('interlocutor', "interlocutor.nombre_completo, interlocutor.id_interlocutor, interlocutor.cargo", ['interlocutor.nombre_completo' => 'ASC'], ['interlocutor.id_estado' => 1]);
        $info['data'] = $interlocutores;


        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'response' => $info
            ]));
    }
    public function registrar_espacio(){

        $espacio['motivo_espacio'] = strtoupper(trim($_POST['motivo_add']));
        $espacio['fecha_registro'] = date('Y-m-d H:i:s');
        $espacio['id_estado'] = 1;
        $espacio['id_usuario'] =  $this->session->sistema->id_usuario;
        $espacio['id_interlocutor'] = $_POST['interlocutor_add'];

        $agenda['id_espacio'] = $this->main->insert('espacio', $espacio, 'espacio_id_espacio_seq');

        $agenda['fecha'] = $_POST['fecha_submit'];
        $agenda['hora'] = $_POST['hora'];
        $agenda['id_programa'] = $_POST['programa'];
        $agenda['lugar'] = $_POST['lugar'];
        $agenda['id_estado'] = 1;
        $agenda['id_usuario'] =  $this->session->sistema->id_usuario;

        $this->main->insert('agenda', $agenda);  

        $this->session->set_flashdata('success', 'Espacio Registrado Correctamente');
        redirect('agenda-medios');        
    }

    public function recuperar_espacio(){

        $id_espacio = $_POST['id'];

        $info['espacio'] = $this->main->get('espacio',['id_espacio'=>$id_espacio]);

        $programas = $this->main->getListSelect('programa', 'id_programa, nombre_programa', ['nombre_programa' => 'ASC']);
        $info['programas'] = $this->main->dropdown($programas);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'response' => $info
            ]));
    }

    public function guardar_agenda(){

        $agenda['id_espacio'] = $_POST['id'];
        $agenda['fecha'] = $_POST['fecha'];
        $agenda['hora'] = $_POST['hora'];
        $agenda['id_programa'] = $_POST['programa'];
        $agenda['lugar'] = $_POST['lugar'];
        $agenda['id_estado'] = 1;
        $agenda['id_usuario'] =  $this->session->sistema->id_usuario;

        $this->main->insert('agenda', $agenda);  


        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'message' => 'Registro Exitoso'
            ]));
    }

    public function obtain_espacio(){

        $id = $_POST['id'];

        $where = "agenda.id_estado = 1 AND agenda.id_espacio = ".$id;

        $agenda = $this->main->getListSelect('agenda', "agenda.id_agenda, to_char(agenda.fecha,'DD/MM/YYYY') as fecha_format, to_char(agenda.hora,'HH24:MI')as hora_format, agenda.lugar, agenda.hora, agenda.fecha, agenda.asistio", ['agenda.fecha' => 'ASC', 'agenda.hora' => 'ASC'], $where);

        $espacio = $this->main->get('espacio',['id_espacio'=>$id],['interlocutor'=>'id_interlocutor']);

        $info['agenda'] = $agenda;
        $info['espacio'] = $espacio;

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'response' => $info
            ]));
    }

    public function eliminar_espacio(){
     
        $id_agenda = $_POST['id_agenda'];
        $id_espacio = $_POST['id_espacio'];

        $actualizacion['id_estado'] = 2;

        $this->main->update('agenda', $actualizacion, ['id_agenda' => $id_agenda]);
        
        $where = "agenda.id_estado = 1 AND agenda.id_espacio = ".$id_espacio;
        $agenda = $this->main->getListSelect('agenda', "agenda.id_agenda, to_char(agenda.fecha,'DD/MM/YYYY') as fecha_format, to_char(agenda.hora,'HH24:MI')as hora_format, agenda.lugar, agenda.hora, agenda.fecha, agenda.asistio", ['agenda.fecha' => 'ASC', 'agenda.hora' => 'ASC'], $where);
        $info['data'] = $agenda;


        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'response' => $info
            ]));
    }

    public function marcar_asistencia(){
     
        $id_agenda = $_POST['id_agenda'];
        $id_espacio = $_POST['id_espacio'];
        $seleccion = $_POST['seleccion'];

        if($seleccion == 1)
        {
            $actualizacion['asistio'] = 'SI';
        }
        else{
            $actualizacion['asistio'] = 'NO';
        }

        $this->main->update('agenda', $actualizacion, ['id_agenda' => $id_agenda]);
        
        $where = "agenda.id_estado = 1 AND agenda.id_espacio = ".$id_espacio;
        $agenda = $this->main->getListSelect('agenda', "agenda.id_agenda, to_char(agenda.fecha,'DD/MM/YYYY') as fecha_format, to_char(agenda.hora,'HH24:MI')as hora_format, agenda.lugar, agenda.hora, agenda.fecha, agenda.asistio", ['agenda.fecha' => 'ASC', 'agenda.hora' => 'ASC'], $where);
        $info['data'] = $agenda;


        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'response' => $info
            ]));
    }



    public function imprimir_espacio(){

        $fecha_ini = set_value("f_ini");
        $fecha_fin = set_value("f_fin");

        $where = "agenda.id_estado = 1 AND espacio.id_estado = 1";
        $hoy = date('Y-m-d');
        //$hoy = '2022-06-13';

        if ($fecha_ini != '' && $fecha_fin != '') {
            $where .= " AND agenda.fecha BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_fin . " 23:59'";
            $data['fecha_ini'] = date("d/m/Y", strtotime($fecha_ini));  
        } else {
            if ($fecha_ini != '') {
                $data['fecha_ini'] = date("d/m/Y", strtotime($fecha_ini));  
                $where .= " AND agenda.fecha BETWEEN '" . $fecha_ini . " 00:00'" . " AND '" . $fecha_ini . " 23:59'";
            } else {
                $data['fecha_ini'] = date("d/m/Y", strtotime($hoy));  
                $where .= " AND agenda.fecha BETWEEN '" . $hoy . " 00:00'" . " AND '" . $hoy . " 23:59'";
            }
        }

        $this->db->join('espacio', 'espacio.id_espacio = agenda.id_espacio', 'left');
        $this->db->join('interlocutor', 'interlocutor.id_interlocutor = espacio.id_interlocutor', 'left');
        $agenda = $this->main->getListSelect('agenda', "agenda.id_espacio, espacio.motivo_espacio, interlocutor.nombre_completo, agenda.fecha", ['agenda.fecha' => 'ASC'], $where);
  
        if($fecha_fin != '')
        {
            $data['fecha_fin'] = date("d/m/Y", strtotime($fecha_fin)); 
        }
        else{
            $data['fecha_fin'] = "";
        }
        
        $data['agenda'] = $agenda;

        //print_r($data['agenda']);
        $this->load->view('agenda/impresion', $data, FALSE);
    }
}
