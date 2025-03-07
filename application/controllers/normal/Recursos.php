<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recursos extends CI_Controller
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

}
