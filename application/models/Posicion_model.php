<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Posicion_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getByTrack($track) {
		$this->db->select('P.id,P.nombre');
		$this->db->join('Posicion_Track PT','PT.posicion = P.id');
		$this->db->join('Tracks T','T.id = PT.track');
		$this->db->where('T.id',$track);
		$this->db->order_by('P.nombre','asc');
		return $this->db->get('Posiciones P')->result();
	}

	function create($nombre) {
		$this->db->insert('Posiciones',array('nombre'=>$nombre));
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		return false;
	}

	function addTrackToPosicion($track,$posicion) {
		$this->db->insert('Posicion_Track',array('posicion'=>$posicion,'track'=>$track));
	}

	function getById($id) {
		$result=$this->db->where('id',$id)->get('Posiciones')->first_row();
		$this->db->select('T.id,T.nombre');
		$this->db->join('Posicion_Track PT','PT.track = T.id');
		$result->tracks = $this->db->where('PT.posicion',$id)->get('Tracks T')->result();

		return $result;
	}

	function addTrack($posicion,$track) {
		$this->db->insert('Posicion_Track',array('posicion'=>$posicion,'track'=>$track));
		if($this->db->insert_id())
			return true;
		return false;
	}

	function delTrack($posicion,$track) {
		$this->db->where(array('posicion'=>$posicion,'track'=>$track));
		$this->db->delete('Posicion_Track');
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function getPosicionTrack($posicion,$track) {
		return $this->db->where(array('posicion'=>$posicion,'track'=>$track))->get('Posicion_Track')->first_row()->id;
	}

	function update($id,$nombre) {
		$this->db->where('id',$id)->update('Posiciones',array('nombre'=>$nombre));
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}
}