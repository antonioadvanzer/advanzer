<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Porcentaje_objetivo_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getByObjetivo($obj) {
		$this->db->where('objetivo',$obj);
		$result = $this->db->get('Porcentajes_Objetivos')->result();
		foreach ($result as $porc) :
			$porc->posiciones = $this->db->where('nivel',$porc->nivel_posicion)->get('Posiciones')->result();
		endforeach;
		return $result;
	}
}