<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Requisicion_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function guardar($datos) {
		$this->db->insert('Requisiciones',$datos);
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		else
			return false;
	}

	function getById($id) {
		$this->db->select('R.*,A.nombre nombre_area,P.nombre nombre_posicion,T.nombre nombre_track,U.nombre nombre_solicita')->join('Areas A','A.id = R.area')
			->join('Posiciones P','P.id = R.posicion')->join('Tracks T','T.id = R.track')->join('Users U','U.id = R.solicita');
		$result=$this->db->where('R.id',$id)->get('Requisiciones R')->first_row();
		$result->nombre_director=$this->db->where('id',$result->director)->get('Users')->first_row()->nombre;
		$result->nombre_autorizador=$this->db->where('id',$result->autorizador)->get('Users')->first_row()->nombre;
		return $result;
	}

	function getRequisiciones($colaborador,$flag) {
		$this->db->select('R.*,T.nombre track,P.nombre posicion,A.nombre area,U.nombre solicitante')
			->join('Tracks T','T.id = R.track')->join('Posiciones P','P.id = R.posicion')->join('Areas A','A.id = R.area')
			->join('Users U','U.id = R.solicita');
		if(!$flag):
			if($colaborador->tipo < 3)
				$this->db->where(array('R.solicita'=>$colaborador->id,'fecha_solicitud <='=>date('Y-m-d')));
			elseif($colaborador->tipo == 3 && $colaborador->area==4)
				$this->db->where('R.estatus',3);
			if(in_array($colaborador->id, array(1,2,51)))
				$this->db->or_where('R.autorizador',$colaborador->id);
			elseif($colaborador->nivel_posicion <= 3)
				$this->db->or_where('R.director',$colaborador->id);
		endif;
		
		return $this->db->get('Requisiciones R')->result();
	}

	function update($id,$datos){
		$this->db->where('id',$id)->update('Requisiciones',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function getPendientesByColaborador($colaborador) {
		$extra="";
		if($this->session->userdata('tipo') >= 3 && $this->session->userdata('area')==4)
			$extra=" or estatus in(3,7)";
		$this->db->where("(director=$colaborador and estatus=1) or (autorizador=$colaborador and estatus=2)$extra");
		return $this->db->get('Requisiciones')->num_rows();
	}
}