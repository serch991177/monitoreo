<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Funcion extends CI_Controller
{


   public function __construct()
   {
      parent::__construct();
      //Do your magic here
      mb_internal_encoding("UTF-8");

      if (!isset($this->session->sistema)) {
         redirect(site_url());
      } else {
         if ($this->session->sistema->id_rol != 1) {
            redirect(site_url());
         }
      }
   }

   /**
    * Listado de Funciones
    *
    * @return void
    */
   public function index()
   {
      $funciones = $this->main->getListSelect('accion', 'accion.*, ROW_NUMBER() OVER (ORDER BY (accion.id_accion)DESC) as row, ', ['id_accion' => 'DESC']);
      $data['funciones'] = json_encode($funciones);

      $this->load->view('administrador/funcion/index', $data, FALSE);
   }

   /**
    * Formulario de registro de Funcion
    *
    * @return void
    */
   public function registrar()
   {

      $funciones = $this->main->getListSelect('accion', 'id_accion, nombre_accion', ['nombre_accion' => 'ASC'], ['es_sub_submenu' => 'NO', 'es_boton' => 'NO']);

      $data['funciones'] = $this->main->dropdown($funciones, '');
      $data['si_no'] = ['' => '', 'SI' => 'SI', 'NO' => 'NO'];
      $this->load->view('administrador/funcion/registrar', $data, FALSE);
   }

   /**
    * Funcion que se encargar de guardar los datos endiados desde registrar
    *
    * @return void
    */
   public function guardar()
   {
      $this->form_validation->set_rules('funcion', lang('funcion'), 'trim|required|ucwords');
      $this->form_validation->set_rules('icono', lang('icono'), 'trim|mb_strtolower');
      $this->form_validation->set_rules('ruta_amigable', lang('ruta.amigable'), 'trim|mb_strtolower');
      $this->form_validation->set_rules('es_menu', lang('es.menu'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('es_submenu', lang('es.submenu'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('es_sub_submenu', lang('es.sub.submenu'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('es_boton', lang('es.boton'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('id_padre', lang('funcion.padre'), 'trim|is_natural_no_zero');
      $this->form_validation->set_rules('estilo', lang('funcion.padre'), 'trim|required|mb_strtolower');

      if ($this->form_validation->run()) {
         $guardar['nombre_accion'] = set_value('funcion');
         $guardar['icon'] = set_value('icono');
         $guardar['ruta_amigable'] = set_value('ruta_amigable');
         $guardar['es_menu'] = set_value('es_menu');
         $guardar['es_submenu'] = set_value('es_submenu');
         $guardar['es_sub_submenu'] = set_value('es_sub_submenu');
         $guardar['es_boton'] = set_value('es_boton');
         $guardar['id_padre'] = set_value('id_padre');
         $guardar['class'] = set_value('estilo');

         $id_accion = $this->main->insert('accion', $guardar, 'accion_id_accion_seq');

         $roles = $this->main->getListSelect('rol', 'id_rol', ['id_rol' => 'ASC']);

         $por_defecto = [];

         foreach ($roles as $rol) {
            $data['id_rol'] = $rol->id_rol;
            $data['id_accion'] = $id_accion;
            $data['id_estado'] = 2;

            array_push($por_defecto, $data);
         }

         $this->db->insert_batch('por_defecto', $por_defecto);

         $usuarios = $this->main->getListSelect('usuario', 'id_usuario', ['id_usuario' => 'ASC'], ['editable' => 'SI'], null, null, ['gestion' => 'id_gestion']);

         $menu = [];

         foreach ($usuarios as $usuario) {
            $dato['id_usuario'] = $usuario->id_usuario;
            $dato['id_accion'] = $id_accion;
            $dato['id_estado'] = 2;

            array_push($menu, $dato);
         }

         $this->db->insert_batch('menu', $menu);

         $this->session->set_flashdata('success', lang('registro.correcto'));

         redirect('funciones');
      } else {
         $this->session->set_flashdata('alert', validation_errors());

         redirect('registrar-funcion');
      }
   }

   /**
    * @requires POST id_funcion
    * @return void
    */

   public function editar()
   {
      $id = set_value('id_funcion');

      $data['funcion'] = $this->main->get('accion', ['id_accion' => $id]);

      $funciones = $this->main->getListSelect('accion', 'id_accion, nombre_accion', ['nombre_accion' => 'ASC'], ['es_sub_submenu' => 'NO', 'es_boton' => 'NO']);
      $data['funciones'] = $this->main->dropdown($funciones, '');
      $data['si_no'] = ['' => '', 'SI' => 'SI', 'NO' => 'NO'];

      $this->load->view('administrador/funcion/editar', $data, FALSE);
   }

   /**
    * Funcion que actualiza segun los datos enviados desde editar
    *
    * @return void
    */
   public function actualizar()
   {
      $this->form_validation->set_rules('funcion', lang('funcion'), 'trim|required|ucwords');
      $this->form_validation->set_rules('icono', lang('icono'), 'trim|mb_strtolower');
      $this->form_validation->set_rules('ruta_amigable', lang('ruta.amigable'), 'trim|mb_strtolower');
      $this->form_validation->set_rules('es_menu', lang('es.menu'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('es_submenu', lang('es.submenu'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('es_sub_submenu', lang('es.sub.submenu'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('es_boton', lang('es.boton'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('id_padre', lang('funcion.padre'), 'trim|is_natural_no_zero');
      $this->form_validation->set_rules('estilo', lang('funcion.padre'), 'trim|required|mb_strtolower');
      $this->form_validation->set_rules('id_funcion', lang('funcion'), 'trim|required|is_natural_no_zero');


      if ($this->form_validation->run()) {
         $actualizar['nombre_accion'] = set_value('funcion');
         $actualizar['icon'] = set_value('icono');
         $actualizar['ruta_amigable'] = set_value('ruta_amigable');
         $actualizar['es_menu'] = set_value('es_menu');
         $actualizar['es_submenu'] = set_value('es_submenu');
         $actualizar['es_sub_submenu'] = set_value('es_sub_submenu');
         $actualizar['es_boton'] = set_value('es_boton');
         $actualizar['id_padre'] = set_value('id_padre');
         $actualizar['class'] = set_value('estilo');

         $id_funcion = set_value('id_funcion');

         $this->main->update('accion', $actualizar, ['id_accion' => $id_funcion]);

         $this->session->set_flashdata('info', lang('actualizacion.correcta'));

         redirect('funciones');
      } else {
         $this->session->set_flashdata('alert', validation_errors());
         redirect('editar-funcion');
      }
   }
}
   
   /* End of file Funcion.php */
