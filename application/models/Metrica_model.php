<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Metrica_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getByObjetivo($obj) {
		$this->db->where('objetivo',$obj);
		$this->db->order_by('valor','desc');
		return $this->db->get('Metricas')->result();
	}

	function searchByObjetivo($obj) {
		$this->db->where('objetivo',$obj);
		$this->db->order_by('valor','desc');
		return $this->db->get('Metricas')->result();
	}

	function getValorByObjetivo($valor,$objetivo) {
		$this->db->where(array('valor'=>$valor,'objetivo'=>$objetivo));
		return $this->db->get('Metricas')->row();
	}

	function update($metrica,$objetivo,$descripcion) {
		if($this->db->from('Metricas')->where(array('valor'=>$metrica,'objetivo'=>$objetivo))->get()->num_rows() == 0)
			$this->db->insert('Metricas',array('valor'=>$metrica,'objetivo'=>$objetivo,'descripcion'=>$descripcion));
		else{
			$this->db->where(array('valor'=>$metrica,'objetivo'=>$objetivo));
			$this->db->update('Metricas',array('descripcion'=>$descripcion));
		}
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}
}