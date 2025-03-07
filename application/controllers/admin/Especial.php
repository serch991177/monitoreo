<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Especial extends CI_Controller
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


   public function index()
   {

      $select = 'ROW_NUMBER() OVER (ORDER BY (especial.id_rol)ASC) as row, dni, especial.id_rol, nombre_rol, descripcion, id_especial, especial.id_estado, registrado, descripcion';
      $dnis = $this->main->getListSelect('especial', $select, ['nombre_rol' => 'ASC'], null, null, null, ['rol' => 'id_rol', 'estado' => 'id_estado']);

      $data['dnis'] = json_encode($dnis);

      $roles = $this->main->getListSelect('rol', 'id_rol, nombre_rol', ['nombre_rol' => 'ASC']);
      $data['roles'] = $this->main->dropdown($roles, 'SELECCIONE UN ROL');

      $this->load->view('administrador/especial/index', $data, FALSE);
   }


   public function registrar()
   {
      $roles = $this->main->getListSelect('rol', 'id_rol, nombre_rol', ['nombre_rol' => 'ASC']);
      $data['roles'] = $this->main->dropdown($roles, '');

      $this->load->view('administrador/especial/registrar', $data, FALSE);
   }

   public function guardar()
   {
      $this->form_validation->set_rules('dni[]', lang('dni'), 'trim|mb_strtoupper');
      $this->form_validation->set_rules('id_rol', lang('rol'), 'trim|required');

      if ($this->form_validation->run()) {
         $registro['id_rol'] = set_value('id_rol');
         $registro['id_estado'] = 1;
         $especial  = set_value('dni');

         $repetidos = '';

         foreach ($especial as $llave => $valor) {

            if ($this->check_dni($valor)) {
               $registro['dni'] = $valor;

               $this->main->insert('especial', $registro);
            } else {
               $repetidos += " " + $valor;
            }
         }

         if ($repetidos == '')
            $this->session->set_flashdata('success', lang('registro.correcto'));
         else
            $this->session->set_flashdata('success', "Los documentos de identidad con número " . $repetidos . " ya se encontraban registrados");
         redirect('dnis');
      } else {
         $this->session->set_flashdata('alert', validation_errors());

         redirect('registrar-dni');
      }
   }

   public function guardar_ant()
   {
      $this->form_validation->set_rules('dni', lang('dni'), 'trim|required|mb_strtoupper|callback_check_dni');
      $this->form_validation->set_rules('id_rol', lang('rol'), 'trim|required');

      if ($this->form_validation->run()) {
         $especial['id_rol'] = set_value('id_rol');
         $especial['dni']    = set_value('dni');

         $this->main->insert('especial', $especial);

         $this->session->set_flashdata('success', lang('registro.correcto'));

         redirect('dnis');
      } else {
         $this->session->set_flashdata('alert', validation_errors());

         redirect('registrar-dni');
      }
   }

   public function cambiar()
   {
      $id_especial = set_value('id_especial');

      $id_estado = $this->main->getField('especial', 'id_estado', ['id_especial' => $id_especial]);

      if ($id_estado == 1) {
         $estado['id_estado'] = 2;
         $this->main->update('especial', $estado, ['id_especial' => $id_especial]);
         echo 0;
      } else {
         $estado['id_estado'] = 1;
         $this->main->update('especial', $estado, ['id_especial' => $id_especial]);
         echo 1;
      }
   }

   public function editar()
   {
      $this->form_validation->set_rules('dni', lang('dni'), 'trim|required|mb_strtoupper|callback_check_dni');
      $this->form_validation->set_rules('id_rol', lang('rol'), 'trim|required');

      if ($this->form_validation->run()) {
         $especial['id_rol'] = set_value('id_rol');
         $especial['dni']    = set_value('dni');
         $id_especial = set_value('especial');

         $this->main->update('especial', $especial, ['id_especial' => $id_especial]);

         $this->session->set_flashdata('success', lang('modificacion.correcto'));

         redirect('dnis');
      } else {
         $this->session->set_flashdata('alert', validation_errors());

         redirect('dnis');
      }
   }

   public function cambiar_ant()
   {
      $id_especial = set_value('id_especial');
      $id_estado = set_value('id_estado');

      if ($id_estado == 1) {
         $estado['id_estado'] = 2;

         $this->main->update('especial', $estado, ['id_especial' => $id_especial]);
      } else {
         $estado['id_estado'] = 1;
         $this->main->update('especial', $estado, ['id_especial' => $id_especial]);
      }

      redirect('dnis');
   }

   public function check_dni($dni)
   {
      $existe_registro = $this->main->get('especial', ['dni' => $dni]);

      if ($existe_registro) {
         $this->form_validation->set_message('check_dni', lang('existe.registro.igual'));
         return FALSE;
      } else {
         return TRUE;
      }
   }
}
   
   /* End of file Controllername.php */
