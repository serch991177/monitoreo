<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Perfil extends CI_Controller
{



   public function __construct()
   {
      parent::__construct();
      //Do your magic here

      mb_internal_encoding("UTF-8");
      if (!isset($this->session->sistema))
         redirect(site_url());
     
   }


   public function index()
   {
      $select = 'unidad_organizacional, cargo, nro_item, correo_municipal, nombre_completo, dni, nombre_rol';
      $id = $this->session->sistema->id_usuario;


      $data['usuario'] = $this->main->getSelect('usuario', $select, ['id_usuario' => $id], ['persona' => 'id_persona', 'rol' => 'id_rol']);

      $this->load->view('general/perfil/index', $data, FALSE);
   }


   public function informacion()
   {
      $data = [];

      $this->load->view('general/perfil/informacion', $data, FALSE);
   }

   public function inicio()
   {
      redirect(site_url());
   }

   public function contrasenia()
   {

      $data['cuenta'] = $this->session->sistema;
      $this->load->view('general/perfil/contrasenia', $data, FALSE);
   }

   public function registrarCambioContrasenia()
   {

      $this->form_validation->set_rules('old_password', lang('contrasenia.antigua'), 'trim|required|min_length[8]|max_length[32]');
      $this->form_validation->set_rules('new_password', lang('contrasenia.nueva'), 'trim|required|min_length[8]|max_length[32]|md5');
      $this->form_validation->set_rules('re_password', lang('repetir.contrasenia'), 'trim|required|min_length[8]|max_length[32]|matches[password]');



      if ($this->form_validation->run() == FALSE) {
         $old_password = md5(set_value('old_password'));
         $id_usuario = $this->session->sistema->id_usuario;

         $existeUsuario =    $this->main->totalSelect('usuario', '*', array('id_usuario' => $id_usuario, 'contrasenia' => $old_password));
         if ($existeUsuario) {
            $cuenta['contrasenia'] = set_value('new_password');
            $cuenta['fecha_actualizacion'] = date('Y-m-d H:i:s');
            $this->main->update('usuario', $cuenta, ['id_usuario' => $id_usuario]);
            $this->session->set_flashdata('success', lang('contrasenia.exitosa'));

            $this->logout();
            redirect(site_url());
         } else {
            $this->session->set_flashdata('alert', lang('contrasenia.erronea'));

            redirect('cambiar-contrasenia');
         }
      } else {
         $this->session->set_flashdata('alert', validation_errors());
         redirect('cambiar-contrasenia');
      }
   }

   public function logout()
   {
      $this->session->userdata = array();
      $this->session->sess_destroy();
      $this->session->unset_userdata('sistema');
      redirect(site_url(), 'refresh');
   }
}
   
   /* End of file Perfil.php */
