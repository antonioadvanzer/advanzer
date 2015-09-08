<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Indicador_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getAll($estatus=null) {
		if($estatus!=null)
			$this->db->where('estatus',$estatus);
		$this->db->order_by('nombre');
		return $this->db->get('Indicadores')->result();
	}

	function getCompetenciasByIndicador($indicador) {
		$this->db->distinct();
		$this->db->select('C.id,C.nombre,C.descripcion,C.estatus');
		$this->db->from('Competencias C');
		$this->db->join('Comportamientos Co','Co.competencia = C.id');
		$this->db->join('Comportamiento_Posicion CP','CP.comportamiento = Co.id');
		$this->db->where('C.indicador',$indicador);
		$this->db->order_by('C.nombre');
		return $this->db->get()->result();
	}

	function getComportamientosByCompetencia($competencia) {
		$this->db->distinct();
		$this->db->select('id,descripcion');
		$this->db->where('competencia',$competencia);
		$this->db->order_by('descripcion','asc');
		$result = $this->db->get('Comportamientos')->result();
		foreach ($result as $comportamiento) :
			$comportamiento->analista = $this->db->from('Comportamiento_Posicion')
				->where(array('comportamiento'=>$comportamiento->id,'nivel_posicion'=>8))->get()->first_row();
			$comportamiento->consultor = $this->db->from('Comportamiento_Posicion')
				->where(array('comportamiento'=>$comportamiento->id,'nivel_posicion'=>7))->get()->first_row();
			$comportamiento->sr = $this->db->from('Comportamiento_Posicion')
				->where(array('comportamiento'=>$comportamiento->id,'nivel_posicion'=>6))->get()->first_row();
			$comportamiento->gerente = $this->db->from('Comportamiento_Posicion')
				->where(array('comportamiento'=>$comportamiento->id,'nivel_posicion'=>5))->get()->first_row();
			$comportamiento->experto = $this->db->from('Comportamiento_Posicion')
				->where(array('comportamiento'=>$comportamiento->id,'nivel_posicion'=>4))->get()->first_row();
			$comportamiento->director = $this->db->from('Comportamiento_Posicion')
				->where(array('comportamiento'=>$comportamiento->id,'nivel_posicion'=>3))->get()->first_row();
		endforeach;
		return $result;
	}

	function searchById($id) {
		return $this->db->where('id',$id)->get('Indicadores')->first_row();
	}

	function update($id,$nombre) {
		$this->db->where('id',$id)->update('Indicadores',array('nombre'=>$nombre));
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function create($nombre) {
		$this->db->insert('Indicadores',array('nombre'=>$nombre));
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function ch_estatus($id,$estatus) {
		$this->db->where('id',$id)->update('Indicadores',array('estatus'=>$estatus));
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

	function addComportamientoPosicion($datos) {
		$this->db->insert('Comportamiento_Posicion',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}
	function delPosicionComportamiento($datos) {
		$this->db->where($datos)->delete('Comportamiento_Posicion');
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}
}