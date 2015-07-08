<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Area_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getAll() {
		return $this->db->get('Areas')->result();
	}

	function searchById($id) {
		$this->db->where('id',$id);
		return $this->db->get('Areas')->first_row();
	}

	function update($id,$nombre,$estatus) {
		$datos = array('nombre'=>$nombre,'estatus'=>$estatus);
		$this->db->where('id',$id);
		$this->db->update('Areas',$datos);
		if ($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function getStatus($id) {
		$this->db->select('estatus');
		$this->db->where('id',$id);
		return $this->db->get('Areas')->first_row()->estatus;
	}

	function change_status($id,$status) {
		$this->db->where('id',$id);
		$this->db->update('Areas',array('estatus'=>$status));
		if ($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function create($nombre,$estatus) {
		$datos=array(
			'nombre'=>$nombre,
			'estatus'=>$estatus
		);
		$this->db->insert('Areas',$datos);
		if($this->db->insert_id())
			return true;
		else
			return false;
	}

	function getByText($valor) {
		$this->db->order_by('nombre','asc');
		$this->db->like('nombre',$valor,'both');
		return $this->db->get('Areas')->result();
	}

	function getByDominio($dominio) {
		$this->db->where('dominio',$dominio);
		return $this->db->get('Areas')->result();
	}

	function getCountResps() {
		$this->db->where('estatus',1);
		return $this->db->count_all('Areas');
	}

	function getByObjetivo($obj) {
		$this->db->select('Re.id,Re.nombre,Do.nombre dominio');
		$this->db->join('Areas Re','OR.area = Re.id');
		$this->db->join('Objetivos O','O.id = OR.objetivo');
		$this->db->join('Dominios Do','O.dominio = Do.id');
		$this->db->where('OR.objetivo',$obj);
		return $this->db->get('Objetivos_Areas OR')->result();
	}


	function getNotObjetivo($asignadas) {
		$array_temp = array();
		if(!empty($asignadas)):
			foreach ($asignadas as $temp) :
				array_push($array_temp, $temp->id);
			endforeach;
			$this->db->where_not_in('Re.id',$array_temp);
		endif;
		$this->db->select('Re.id,Re.nombre');
		$this->db->join('Objetivos_Areas Ob_R','Ob_R.area = Re.id','LEFT OUTER');
		$this->db->join('Objetivos O','O.id = Ob_R.objetivo','LEFT OUTER');
		return $this->db->get('Areas Re')->result();
	}

}