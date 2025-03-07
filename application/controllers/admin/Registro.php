<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Login
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Registro extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!isset($this->session->sistema)) {
      redirect(site_url());
    } else {
      if ($this->session->sistema->id_rol != 1) {
        redirect(site_url());
      }
    }
  }

  public function index()
  {
    $roles = $this->main->getListSelect('rol', 'id_rol, nombre_rol', ['nombre_rol' => 'ASC']);
    $data['roles'] = $this->main->dropdown($roles, 'SELECCIONE UN ROL');

    /*$areas = $this->main->getListSelect('unidad', 'id_unidad, descripcion', ['descripcion' => 'ASC']);
    $data['unidades'] = $this->main->dropdown($areas, 'SELECCIONE UNA UNIDAD');*/

    $this->load->view('administrador/registro/registro', $data);
  }

  public function registro()
  {
    mb_internal_encoding("UTF-8");

    $this->form_validation->set_rules('dni', lang('dni'), 'trim|required|mb_strtoupper|callback_dni_check');
    $this->form_validation->set_rules('nombre_completo', lang('nombre.completo'), 'trim|required|mb_strtoupper');
    $this->form_validation->set_rules('unidad_organizacional', lang('unidad.organizacional'), 'trim|required|mb_strtoupper');
    $this->form_validation->set_rules('cargo', lang('cargo'), 'trim|required|mb_strtoupper');
    $this->form_validation->set_rules('nro_item', lang('nro.item'), 'trim|required');
    $this->form_validation->set_rules('rol', lang('rol'), 'required');
    $this->form_validation->set_rules('register_correo', lang('correo'), 'trim|required|mb_strtolower|valid_email');
    $this->form_validation->set_rules('register_password', lang('password'), 'trim|required|mb_strtoupper|md5');


    if ($this->form_validation->run()) {
      $id_rol = set_value('rol');

      $funciones = $this->main->getListSelect('por_defecto', 'id_accion, id_estado', ['id_accion' => 'ASC'], ['id_rol' => $id_rol]);

      $persona_existe = $this->main->get('persona', ['dni' => set_value('dni')]);
      $gestion_activa = $this->main->get('gestion', ['editable' => 'SI']);

      if (!$persona_existe) {
        $persona['dni'] = set_value('dni');
        $persona['nombre_completo'] = set_value('nombre_completo');
        $persona['fecha_registro'] = date('Y-m-d H:i:s');
        $persona['fecha_habilitacion'] = date('Y-m-d H:i:s');
        $persona['id_estado'] = 1;

        $id  = $this->main->insert('persona', $persona, 'persona_id_persona_seq');
      } else {
        $id = $persona_existe->id_persona;
      }

      $registro['id_persona'] = $id;
      $registro['id_gestion'] = $gestion_activa->id_gestion;
      $registro['id_rol'] = $id_rol;
      $registro['fecha_registro'] = date('Y-m-d H:i:s');
      $registro['unidad_organizacional'] = set_value('unidad_organizacional');
      $registro['cargo'] = set_value('cargo');
      $registro['nro_item'] = set_value('nro_item');
      //$registro['id_unidad'] = set_value('unidad');
      $registro['correo_municipal'] = set_value('register_correo');
      $registro['contrasenia'] = set_value('register_password');

      $id_usuario = $this->main->insert('usuario', $registro, 'usuario_id_usuario_seq');

      $menu = [];

      foreach ($funciones as $funcion) {
        $dato['id_accion'] = $funcion->id_accion;
        $dato['id_estado'] = $funcion->id_estado;
        $dato['id_usuario'] = $id_usuario;

        array_push($menu, $dato);
      }

      $this->db->insert_batch('menu', $menu);
      $this->session->set_flashdata('success', lang('registro.correcto'));
      redirect('registrar-usuario ');
    } else {
      $this->session->set_flashdata('alert', validation_errors());
      redirect('registrar-usuario');
    }
  }

  public function dni_check($dni)
  {

    $existe_usuario = $this->main->get('usuario', ['dni' => $dni, 'editable' => 'AB'], ['persona' => 'id_persona', 'gestion' => 'id_gestion']);

    if ($existe_usuario) {
      $this->form_validation->set_message('dni_check', lang('existe.usuario'));
      return FALSE;
    } else {
      return TRUE;
    }
  }
}


/* End of file Resgistro.php */
/* Location: ./application/controllers/Registro.php */