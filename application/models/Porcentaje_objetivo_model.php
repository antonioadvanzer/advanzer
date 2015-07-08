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
		return $this->db->get('Porcentajes_Objetivos')->result();
	}
}