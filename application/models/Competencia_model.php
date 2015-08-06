<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Competencia_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function create($nombre,$indicador,$descripcion) {
		$this->db->insert('Competencias',array('nombre'=>$nombre,'indicador'=>$indicador,'descripcion'=>$descripcion));
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		else
			return false;
	}

	function searchById($id) {
		$result=$this->db->where('id',$id)->get('Competencias')->first_row();
		$result->comportamientos=$this->db->where('competencia',$id)->get('Comportamientos')->result();
		return $result;
	}

	function addComportamiento($competencia,$descripcion) {
		$this->db->insert('Comportamientos',array('descripcion'=>$descripcion,'competencia'=>$competencia));
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		else
			return false;
	}

	function addPosicionToComportamiento($comportamiento,$posicion) {
		$this->db->insert('Comportamiento_Posicion',array('nivel_posicion'=>$posicion,'comportamiento'=>$comportamiento));
	}

	function delComportamiento($comportamiento) {
		if($this->db->where('comportamiento',$comportamiento)->delete('Comportamiento_Posicion'))
			$this->db->where('id',$comportamiento)->delete('Comportamientos');
	}

	function update($id,$nombre,$descripcion,$indicador) {
		$this->db->where('id',$id)->update('Competencias',array('nombre'=>$nombre,'descripcion'=>$descripcion,'indicador'=>$indicador));
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}
}