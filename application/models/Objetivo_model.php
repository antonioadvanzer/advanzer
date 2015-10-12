<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Objetivo_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getByDominio($dominio,$area,$tipo) {
		$this->db->select('O.id,O.nombre,D.nombre dominio,O.descripcion,O.estatus,O.tipo');
		$this->db->from('Objetivos O');
		$this->db->join('Objetivos_Areas OA','OA.objetivo = O.id');
		$this->db->join('Dominios D','D.id = O.dominio');
		$this->db->where(array('OA.area'=>$area));
		if($dominio)
			$this->db->where('O.dominio',$dominio);
		if($tipo)
			$this->db->where('O.tipo',$tipo);
		$this->db->order_by('D.nombre, O.nombre');
		return $this->db->get()->result();
	}

	function searchById($id) {
		$this->db->select('Ob.id,Ob.nombre,Ob.descripcion,Ob.estatus,Ob.dominio,Ob.tipo');
		$this->db->where('Ob.id',$id);
		$this->db->from('Objetivos as Ob');
		$this->db->join('Dominios as Do','Ob.dominio = Do.id');
		$result = $this->db->get()->first_row();
		$result->metricas = $this->db->where('objetivo',$result->id)->get('Metricas')->result();
		return $result;
	}

	function add_area($obj,$area) {
		$result = $this->db->where(array('objetivo'=>$obj,'area'=>$area))->get('Objetivos_Areas');
		if($result->num_rows() == 0){
			$this->db->insert('Objetivos_Areas',array('area'=>$area,'objetivo'=>$obj));
			if($this->db->affected_rows() != 1)
				return false;
		}
		return true;
	}

	function del_area($obj,$area) {
		$result = $this->db->where(array('objetivo'=>$obj,'area'=>$area))->get('Objetivos_Areas');
		if($result->num_rows() == 1){
			$objetivo_area = $result->first_row()->id;
			$result = $this->db->where('objetivo_area',$objetivo_area)->get('Porcentajes_Objetivos');
			if($result->num_rows() > 0)
				$this->db->where('objetivo_area',$objetivo_area)->delete('Porcentajes_Objetivos');
			$this->db->where(array('objetivo'=>$obj,'area'=>$area))->delete('Objetivos_Areas');
			if (!$this->db->affected_rows() == 1) 
				return false;
		}
		return true;
	}

	function update($id,$datos) {
		$this->db->where('id',$id)->update('Objetivos',$datos);
		if ($this->db->affected_rows() == 1) 
			return true;
		return false;
	}

	function create($datos) {
		$this->db->insert('Objetivos',$datos);
		if($this->db->affected_rows() == 1)
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

	function ch_estatus($id) {
		$estatus = abs($this->db->where('id',$id)->get('Objetivos')->first_row()->estatus - 1);
		if($this->db->where('id',$id)->update('Objetivos',array('estatus'=>$estatus)))
			return true;
		return false;
	}
}