<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Defecto extends CI_Controller
{



   public function __construct()
   {
      parent::__construct();
      //Do your magic here

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
      $select = 'ROW_NUMBER() OVER (ORDER BY (por_defecto.id_rol)ASC) as row, id_por_defecto, por_defecto.id_estado, por_defecto.id_rol, nombre_rol, nombre_accion, descripcion, icon';
      $defecto = $this->main->getListSelect('por_defecto', $select, ['por_defecto.id_rol' => 'ASC'], null, null, null, ['accion' => 'id_accion', 'rol' => 'id_rol', 'estado' => 'id_estado']);

      $data['defecto'] = json_encode($defecto);

      $this->load->view('administrador/defecto/index', $data, FALSE);
   }

   public function cambiar()
   {
      $id_por_defecto = set_value('id_por_defecto');

      $id_estado = $this->main->getField('por_defecto', 'id_estado', ['id_por_defecto' => $id_por_defecto]);

      if ($id_estado == 1) {
         $estado['id_estado'] = 2;
         $this->main->update('por_defecto', $estado, ['id_por_defecto' => $id_por_defecto]);
         echo 0;
      } else {
         $estado['id_estado'] = 1;
         $this->main->update('por_defecto', $estado, ['id_por_defecto' => $id_por_defecto]);
         echo 1;
      }
   }

   public function cambiar_ant()
   {
      $id_por_defecto = set_value('id_por_defecto');
      $id_estado = set_value('id_estado');

      if ($id_estado == 1) {
         $estado['id_estado'] = 2;

         $this->main->update('por_defecto', $estado, ['id_por_defecto' => $id_por_defecto]);
      } else {
         $estado['id_estado'] = 1;
         $this->main->update('por_defecto', $estado, ['id_por_defecto' => $id_por_defecto]);
      }

      redirect('por-defecto');
   }


   public function registrar()
   {
      $funciones = $this->main->getListSelect('accion', 'id_accion, nombre_accion', ['nombre_accion' => 'ASC']);
      $data['funciones'] = $this->main->dropdown($funciones, '');


      $roles = $this->main->getListSelect('rol', 'id_rol, nombre_rol', ['nombre_rol' => 'ASC']);
      $data['roles'] = $this->main->dropdown($roles, '');


      $this->load->view('administrador/defecto/registrar', $data, FALSE);
   }


   public function guardar()
   {
      $this->form_validation->set_rules('id_accion', lang('funcion'), 'trim|required|callback_check_existe');
      $this->form_validation->set_rules('id_rol', lang('funcion'), 'trim|required');

      if ($this->form_validation->run()) {
         $guardar['id_accion'] = set_value('id_accion');
         $guardar['id_rol'] = set_value('id_rol');
         $guardar['id_estado'] = 1;

         $this->main->insert('por_defecto', $guardar);

         redirect('por-defecto');
      } else {
         $this->session->set_flashdata('alert', validation_errors());

         redirect('registrar-por-defecto');
      }
   }

   public function check_existe()
   {
      $dato['id_accion'] = set_value('id_accion');
      $dato['id_rol'] = set_value('id_rol');

      $existe_registro = $this->main->get('por_defecto', $dato);

      if ($existe_registro) {
         $this->form_validation->set_message('check_existe', lang('existe.registro.igual'));
         return FALSE;
      } else {
         return TRUE;
      }
   }
}
   
   /* End of file Controllername.php */
