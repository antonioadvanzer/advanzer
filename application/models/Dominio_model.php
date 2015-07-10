<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Dominio_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->model('area_model');
	}

	function getAll(){
		return $this->db->get('Dominios')->result();
	}

	function getPagination($limit,$start) {
		$this->db->limit($limit,$start);
		$this->db->order_by('nombre','asc');
		return $this->db->get('Dominios')->result();
	}
}