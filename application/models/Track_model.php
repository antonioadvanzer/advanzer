<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Track_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getAll() {
		return $this->db->get('Tracks')->result();
	}

	function create($nombre) {
		$this->db->insert('Tracks',array('nombre'=>$nombre));
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

	function getNotByPosicion($posicion) {
		$temp=array();
		foreach ($this->db->select('T.id')->from('Tracks T')->join('Posicion_Track PT','PT.track = T.id')->where('PT.posicion',$posicion)->get()->result_array() as $array) :
			array_push($temp, $array['id']);
		endforeach;
		$this->db->from('Tracks');
		if(!empty($temp))
			$this->db->where_not_in('id',$temp);
		return $this->db->get()->result();
	}

	function getById($id) {
		return $this->db->where('id',$id)->get('Tracks')->first_row();
	}

	function update($id,$nombre) {
		$this->db->where('id',$id)->update('Tracks',array('nombre'=>$nombre));
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}
}