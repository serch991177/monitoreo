<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bienvenido extends CI_Controller
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
      $data = [];

      $this->load->view('administrador/bienvenido/index', $data, FALSE);
   }
}

/* End of file Controllername.php */
