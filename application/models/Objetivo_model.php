<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Objetivo_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getByDominioArea($dominio,$area) {
		$this->db->select('O.id,O.nombre,O.descripcion,O.estatus');
		$this->db->join('Objetivos_Areas OA','O.id = OA.objetivo');
		$this->db->where(array('O.dominio'=>$dominio,'OA.area'=>$area));
		return $this->db->get('Objetivos O')->result();
	}

	function searchById($id) {
		$this->db->select('Ob.id,Ob.nombre,Ob.descripcion,Ob.estatus,Ob.dominio');
		$this->db->where('Ob.id',$id);
		$this->db->from('Objetivos as Ob');
		$this->db->join('Dominios as Do','Ob.dominio = Do.id');
		return $this->db->get()->first_row();
	}

	function add_area($obj,$resp) {
		$this->db->insert('Objetivos_Areas',array('area'=>$resp,'objetivo'=>$obj));
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function del_area($objetivo,$area) {
		$this->db->where(array('objetivo'=>$objetivo,'area'=>$area));
		$this->db->delete('Objetivos_Areas');
		if ($this->db->affected_rows() == 1) 
			return true;
		else
			return false;
	}

	function update($id,$nombre,$dominio,$descripcion) {
		$this->db->where('id',$id);
		$this->db->update('Objetivos',array('nombre'=>$nombre,'dominio'=>$dominio,'descripcion'=>$descripcion));
		if ($this->db->affected_rows() == 1) 
			return true;
		else
			return false;
	}

	function create($nombre,$dominio,$descripcion) {
		if($this->db->insert('Objetivos',array('nombre'=>$nombre,'dominio'=>$dominio,'descripcion'=>$descripcion)))
			return $this->db->insert_id();
		else
			return false;
	}

	function getPesoByPosicion($objetivo,$posicion) {
		$this->db->where(array('objetivo'=>$objetivo,'nivel_posicion'=>$posicion));
		return $this->db->get('Porcentajes_Objetivos')->first_row();
	}

	function update_peso($objetivo,$posicion,$valor) {
		if($this->db->from('Porcentajes_Objetivos')->where(array('objetivo'=>$objetivo,'nivel_posicion'=>$posicion))->get()->num_rows() == 0)
			$this->db->insert('Porcentajes_Objetivos',array('objetivo'=>$objetivo,'nivel_posicion'=>$posicion,'valor'=>$valor));
		else{
			$this->db->where(array('objetivo'=>$objetivo,'nivel_posicion'=>$posicion));
			$this->db->update('Porcentajes_Objetivos',array('valor'=>$valor));
		}
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}
}