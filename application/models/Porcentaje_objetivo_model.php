<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Porcentaje_objetivo_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getByObjetivoPosicion($obj,$nivel) {
		$this->db->where(array('objetivo'=>$obj,'nivel_posicion'=>$nivel));
		return $this->db->get('Porcentajes_Objetivos')->result();
		/*foreach ($result as $porc) :
			$porc->posiciones = $this->db->where('nivel',$porc->nivel_posicion)->order_by('nombre','asc')->get('Posiciones')->result();
		endforeach;
		return $result;*/
	}
}