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
		return $this->db->get('Indicadores')->result();
	}

	function getCompetenciasByIndicadorPosicion($indicador,$posicion) {
		$this->db->distinct();
		$this->db->select('C.id,C.nombre,C.descripcion,C.estatus,C.puntuacion');
		$this->db->from('Competencias C');
		$this->db->join('Comportamientos Co','Co.competencia = C.id');
		$this->db->join('Comportamiento_Posicion CP','CP.comportamiento = Co.id');
		$this->db->where(array('C.indicador'=>$indicador,'CP.posicion'=>$posicion));
		return $this->db->get()->result();
	}

	function getComportamientosByCompetenciaPosicion($competencia,$posicion) {
		$this->db->select('C.descripcion');
		$this->db->join('Comportamiento_Posicion CP','CP.comportamiento = C.id');
		$this->db->where(array('C.competencia'=>$competencia,'CP.posicion'=>$posicion));
		return $this->db->get('Comportamientos C')->result();
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
}