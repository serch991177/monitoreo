<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('login')){
	function login()
	{
		$CI =& get_instance();
      exit($CI->load->view('general/login/login', null, TRUE));
	}
}
if(! function_exists('fecha')) {
	function fecha($fecha="") {
		$CI =& get_instance();

		if($fecha != null) {
			$formato = explode('-', $fecha);

			switch ($formato[1]) {

			case 1: return $formato[2]." Enero del ".$formato[0];
			case 2: return $formato[2]." Febrero del ".$formato[0];
			case 3: return $formato[2]." Marzo del ".$formato[0];
			case 4: return $formato[2]." Abril del ".$formato[0];
			case 5: return $formato[2]." Mayo del ".$formato[0];
			case 6: return $formato[2]." Junio del ".$formato[0];
			case 7: return $formato[2]." Julio del ".$formato[0];
			case 8: return $formato[2]." Agosto del ".$formato[0];
			case 9: return $formato[2]." Septiembre del ".$formato[0];
			case 10: return $formato[2]." Octubre del ".$formato[0];
			case 11: return $formato[2]." Noviembre del ".$formato[0];
			case 12: return $formato[2]." Diciembre del ".$formato[0];

			}
		}

		else
			return '';
	}
}
