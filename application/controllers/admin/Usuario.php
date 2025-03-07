<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Usuario extends CI_Controller
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
    * Listado de Usuarios Registrados de la presente Gestion
    *
    * @return void
    */
   public function index()
   {

      $select = 'ROW_NUMBER() OVER (ORDER BY (nombre_completo)ASC) as row, id_usuario, nombre_completo, dni, unidad_organizacional, cargo, nro_item, correo_municipal, usuario.id_rol, nombre_rol';
      $usuarios = $this->main->getListSelect('usuario', $select, ['nombre_completo' => 'DESC'], ['editable' => 'SI'], null, null, ['persona' => 'id_persona', 'gestion' => 'id_gestion', 'rol' => 'id_rol']);
      $data['usuarios'] = json_encode($usuarios);

      $roles = $this->main->getListSelect('rol', 'id_rol, nombre_rol', ['nombre_rol' => 'ASC']);
      $data['roles'] = $this->main->dropdown($roles);

      $this->load->view('administrador/usuario/index', $data, FALSE);
   }


   public function funciones($id)
   {
      $select = 'id_menu, menu.id_estado, id_usuario, nombre_accion,ruta_amigable, icon, descripcion';
      $where = ['id_usuario' => $id];
      $join = ['accion' => 'id_accion', 'estado' => 'id_estado'];
      $funciones = $this->main->getListSelect('menu', $select, ['id_menu' => 'ASC'], $where, null, null, $join);

      $this->db->join('usuario', 'persona.id_persona = usuario.id_persona');
      $usuario = $this->main->getField('persona', 'nombre_completo', ['usuario.id_usuario' => $id]);

      $data['funciones'] = json_encode($funciones);
      $data['id'] = $id;
      $data['usuario'] = $usuario;

      $this->load->view('administrador/usuario/funciones', $data, FALSE);
   }

   public function cambiar_estado()
   {
      $id_menu = set_value('id_menu');

      $id_estado = $this->main->getField('menu', 'id_estado', ['id_menu' => $id_menu]);

      if ($id_estado == 1) {
         $estado['id_estado'] = 2;
         $this->main->update('menu', $estado, ['id_menu' => $id_menu]);
         echo 0;
      } else {
         $estado['id_estado'] = 1;
         $this->main->update('menu', $estado, ['id_menu' => $id_menu]);
         echo 1;
      }
   }

   public function editar()
   {
      $id_usuario = set_value('usuario');

      $data['usuario'] = $this->main->get('persona', ['id_usuario' => $id_usuario], ['usuario' => 'id_persona']);

      $this->load->view('administrador/usuario/editar', $data, FALSE);
   }

   public function modificar()
   {
      mb_internal_encoding("UTF-8");

      $this->form_validation->set_rules('nombre_completo', lang('nombre.completo'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('unidad_organizacional', lang('unidad.organizacional'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('cargo', lang('cargo'), 'trim|required|mb_strtoupper');
      $this->form_validation->set_rules('nro_item', lang('nro.item'), 'trim|required');
      $this->form_validation->set_rules('register_correo', lang('correo'), 'trim|required|mb_strtolower|valid_email');


      if ($this->form_validation->run()) {

         $id_usuario = set_value('usuario');
         $id_persona = set_value('persona');

         $persona['nombre_completo'] = set_value('nombre_completo');
         $persona['fecha_modificacion'] = date('Y-m-d H:i:s');

         $this->main->update('persona', $persona, ['id_persona' => $id_persona]);

         $modificacion['unidad_organizacional'] = set_value('unidad_organizacional');
         $modificacion['cargo'] = set_value('cargo');
         $modificacion['nro_item'] = set_value('nro_item');
         $modificacion['correo_municipal'] = set_value('register_correo');

         $this->main->update('usuario', $modificacion, ['id_persona' => $id_persona]);

         $this->session->set_flashdata('success', lang('modificacion.correcta'));
         
      } else {
         $this->session->set_flashdata('alert', validation_errors());
      }
      redirect('usuarios');
   }

   public function cambiar_rol()
   {
      $id_usuario = set_value('id_usuario');
      $rol = set_value('id_rol');
      $rol_ant = set_value('rol_ant');

      if ($rol_ant != $rol) {
         $estado['id_estado'] = 2;

         $this->main->update('menu', $estado, ['id_usuario' => $id_usuario]);

         $funciones = $this->main->getListSelect('por_defecto', 'id_accion', ['id_accion' => 'ASC'], ['id_rol' => $rol, 'id_estado' => 1]);

         foreach ($funciones as $funcion) {
            $dato['id_estado'] = 1;

            $this->main->update('menu', $dato, ['id_usuario' => $id_usuario, 'id_accion' => $funcion->id_accion]);
         }

         $this->session->set_flashdata('success', lang('cambio.exito'));
      } else {
         $this->session->set_flashdata('alert', lang('seleccionar.rol'));
      }
      redirect('usuarios');
   }

   public function cambiar_estado_ant()
   {
      $id_menu = set_value('id_menu');
      $id_estado = set_value('id_estado');
      $id_usuario = set_value('id_usuario');


      if ($id_estado == 1) {
         $estado['id_estado'] = 2;

         $this->main->update('menu', $estado, ['id_menu' => $id_menu]);
      } else {
         $estado['id_estado'] = 1;
         $this->main->update('menu', $estado, ['id_menu' => $id_menu]);
      }

      redirect('funciones-usuario/' . $id_usuario);
   }
}
   
   /* End of file Controllername.php */
