<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Area_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getAll($estatus=null) {
		if($estatus!=null)
			$this->db->where('estatus',$estatus);
		$this->db->select('A.id,A.nombre,D.nombre direccion,A.estatus');
		$this->db->join('Direcciones D','D.id = A.direccion','LEFT OUTER');
		$this->db->order_by('nombre','asc');
		return $this->db->get('Areas A')->result();
	}

	function searchById($id) {
		$this->db->where('id',$id);
		return $this->db->get('Areas')->first_row();
	}

	function getDirecciones() {
		return $this->db->get('Direcciones')->result();
	}

	function update($id,$datos) {
		$this->db->where('id',$id)->update('Areas',$datos);
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

	function create($datos) {
		$this->db->insert('Areas',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function getByText($valor,$estatus,$orden) {
		if($estatus < 2)
			$this->db->where('estatus',$estatus);
		$this->db->order_by('nombre',$orden);
		$this->db->like('nombre',$valor,'both');
		return $this->db->get('Areas')->result();
	}

	function getByDominio($dominio) {
		$this->db->where('dominio',$dominio);
		$this->db->order_by('nombre','asc');
		return $this->db->get('Areas')->result();
	}

	function getCountResps() {
		$this->db->where('estatus',1);
		return $this->db->count_all('Areas');
	}

	function getByObjetivo($obj) {
		$this->db->select('A.id,A.nombre,Do.nombre dominio');
		$this->db->join('Areas A','OR.area = A.id');
		$this->db->join('Objetivos O','O.id = OR.objetivo');
		$this->db->join('Dominios Do','O.dominio = Do.id');
		$this->db->where('OR.objetivo',$obj);
		$this->db->order_by('A.nombre','asc');
		return $this->db->get('Objetivos_Areas OR')->result();
	}


	function getNotObjetivo($asignadas) {
		$array_temp = array();
		if(!empty($asignadas)):
			foreach ($asignadas as $temp) :
				array_push($array_temp, $temp->id);
			endforeach;
			$this->db->where_not_in('A.id',$array_temp);
		endif;
		$this->db->distinct();
		$this->db->select('A.id,A.nombre');
		$this->db->join('Objetivos_Areas Ob_R','Ob_R.area = A.id','LEFT OUTER');
		$this->db->join('Objetivos O','O.id = Ob_R.objetivo','LEFT OUTER');
		$this->db->order_by('A.nombre','asc');
		return $this->db->get('Areas A')->result();
	}

	function searchByObjetivo($obj) {
		$this->db->select('A.id,A.nombre');
		$this->db->from('Areas A');
		$this->db->join('Objetivos_Areas OA','A.id = OA.area');
		$this->db->where('OA.objetivo',$obj);
		$this->db->order_by('A.nombre','asc');
		return $this->db->get()->result();
	}

	function getByDireccion($direccion) {
		$result = $this->db->where(array('direccion'=>$direccion,'estatus'=>1))->order_by('nombre')
			->get('Areas')->result();
		foreach ($result as $area) {
			$area->objetivos = $this->db->select('O.id,O.nombre')->from('Objetivos O')
				->join('Objetivos_Areas OA','OA.objetivo = O.id')
				->where(array('O.estatus'=>1,'OA.area'=>$area->id))->order_by('O.nombre')->get()->result();
		}
		return $result;
	}

}