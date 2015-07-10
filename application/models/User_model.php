<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class User_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function do_login($email,$password){
		$this->db->select('id,email,nombre,foto,empresa');
		$this->db->from('Users');
		$this->db->where('email',$email);
		$this->db->where('estatus',1);
		if($password != "google")
			$this->db->where('password',md5($password));
		$this->db->limit(1);

		$query=$this->db->get();
		if ($query->num_rows() == 1) 
			return $query->first_row();
		else
			return false;
	}

	function getCountUsers() {
		return $this->db->count_all('Users');
	}

	function getPagination($limit,$start) {
		$this->db->select('U.id,U.nombre,U.email,U.foto,U.empresa,U.tipo,U.posicion,U.estatus,A.nombre area');
		$this->db->join('Areas A','U.area = A.id','LEFT OUTER');
		$this->db->limit($limit,$start);
		$this->db->order_by('nombre','asc');
		//$this->db->where('estatus',1);
		return $this->db->get('Users U')->result();
	}

	function searchById($id) {
		$this->db->where('id',$id);
		return $this->db->get('Users')->first_row();
	}

	function update_foto($id,$nombre) {
		$this->db->where('id',$id);
		$this->db->update('Users',array('foto'=>$nombre));
	}

	function update($id,$nombre,$email,$tipo,$area,$posicion,$estatus) {
		$datos=array(
			'nombre'=>$nombre,
			'email'=>$email,
			'tipo'=>$tipo,
			'area'=>$area,
			'estatus'=>$estatus,
			'posicion'=>$posicion
		);
		$this->db->where('id',$id);
		$this->db->update('Users',$datos);
		if($this->db->affected_rows() == 1)
			return TRUE;
		else
			return FALSE;
	}

	function create($nombre,$email,$empresa,$tipo,$area,$posicion,$estatus) {
		$datos=array(
			'nombre'=>$nombre,
			'email'=>$email,
			'empresa'=>$empresa,
			'tipo'=>$tipo,
			'area'=>$area,
			'estatus'=>$estatus,
			'posicion'=>$posicion
		);
		try {
			$this->db->insert('Users',$datos);
			return $this->db->insert_id();
		} catch (Exception $e) {
			return false;
		}
	}

	function getStatus($id) {
		$this->db->select('estatus');
		$this->db->where('id',$id);
		return $this->db->get('Users')->first_row()->estatus;
	}

	function change_status($id,$status) {
		$this->db->where('id',$id);
		$this->db->update('Users',array('estatus'=>$status));
		if ($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function getByText($valor) {
		$this->db->order_by('nombre','asc');
		$this->db->like('nombre',$valor,'both');
		$this->db->or_like('email',$valor);
		$this->db->or_like('posicion',$valor);
		$this->db->or_like('tipo',$valor);
		return $this->db->get('Users')->result();
	}
	function getAll($tipo=null) {
		if($tipo == 1)
			$this->db->where_in('posicion',array('Gerente / Master','Gerente Sr / Experto','Director'));
		return $this->db->order_by('nombre','asc')->get('Users')->result();
	}
}