<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Dominio_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->model('area_model');
	}

	function getAll($estatus=1){
		if($estatus!=null)
			$this->db->where('estatus',$estatus);
		$this->db->order_by('nombre','asc');
		return $this->db->get('Dominios')->result();
	}

	function getPagination($limit,$start) {
		$this->db->limit($limit,$start);
		$this->db->order_by('nombre','asc');
		return $this->db->get('Dominios')->result();
	}

	function create($datos) {
		$this->db->insert('Dominios',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

	function getEstatusById($id) {
		$this->db->select('estatus');
		$this->db->where('id',$id);
		return $this->db->get('Dominios')->first_row()->estatus;
	}

	function ch_estatus($id,$estatus) {
		$this->db->where('id',$id);
		$this->db->update('Dominios',array('estatus'=>$estatus));
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function searchById($id) {
		$this->db->where('id',$id);
		return $this->db->get('Dominios')->first_row();
	}

	function update($id,$datos) {
		$this->db->where('id',$id);
		$this->db->update('Dominios',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}
}