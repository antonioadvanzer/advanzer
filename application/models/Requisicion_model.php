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
		$this->db->select('R.*,A.nombre nombre_area,P.nombre nombre_posicion,T.nombre nombre_track,U.nombre nombre_solicita')->join('Areas A','A.id = R.area','LEFT OUTER')->join('Posiciones P','P.id = R.posicion','LEFT OUTER')->join('Tracks T','T.id = R.track','LEFT OUTER')->join('Users U','U.id = R.solicita');
		$result=$this->db->where('R.id',$id)->get('Requisiciones R')->first_row();
		$result->nombre_director=$this->db->where('id',$result->director)->get('Users')->first_row()->nombre;
		$result->nombre_autorizador=$this->db->where('id',$result->autorizador)->get('Users')->first_row()->nombre;
		
		return $result;
	}
	
	// To set alert if user ever seen this Requisición
	function setAlert($id,$alert){
		$datos['alerta'] = $alert;
		$this->db->where('id',$id)->update('Requisiciones',$datos);
	}

	function getRequisiciones($status) {
		$this->db->select('R.*,T.nombre track,P.nombre posicion,A.nombre area,U.nombre solicitante')
			->join('Tracks T','T.id = R.track','LEFT OUTER')->join('Posiciones P','P.id = R.posicion','LEFT OUTER')->join('Areas A','A.id = R.area','LEFT OUTER')
			->join('Users U','U.id = R.solicita');
		/*if(!$flag):
			if($colaborador->tipo < 3)
				$this->db->where(array('R.solicita'=>$colaborador->id,'fecha_solicitud <='=>date('Y-m-d')));
			elseif($colaborador->tipo == 3 && $colaborador->area==4)
				$this->db->where('R.estatus',3);
			if(in_array($colaborador->id, array(1,2,51)))
				$this->db->or_where('R.autorizador',$colaborador->id);
			elseif($colaborador->nivel_posicion <= 3)
				$this->db->or_where('R.director',$colaborador->id);
		endif;*/
		
		// Determinate requisiciones status
		if($status!="all"):
			$this->db->where('R.estatus',$status);
		endif;
				
		return $this->db->get('Requisiciones R')->result();
	}
	
	function getOwnRequisiciones($id){
		
		$this->db->select('R.*,T.nombre track,P.nombre posicion,A.nombre area,U.nombre solicitante')
			->join('Tracks T','T.id = R.track','LEFT OUTER')->join('Posiciones P','P.id = R.posicion','LEFT OUTER')->join('Areas A','A.id = R.area','LEFT OUTER')
			->join('Users U','U.id = R.solicita');

			/*if($colaborador->tipo < 3)
				$this->db->where(array('R.solicita'=>$colaborador->id,'fecha_solicitud <='=>date('Y-m-d')));
			elseif($colaborador->tipo == 3 && $colaborador->area==4)
				$this->db->where('R.estatus',3);
			if(in_array($colaborador->id, array(1,2,51)))
				$this->db->or_where('R.autorizador',$colaborador->id);
			elseif($colaborador->nivel_posicion <= 3)
				$this->db->or_where('R.director',$colaborador->id);*/
				
		//$this->db->where(array('R.solicita'=>( $uc = $colaborador->id),'fecha_solicitud <='=>date('Y-m-d')));
		
		$this->db->where("((R.solicita=".$id.") or (R.director=".$id." and R.estatus=1) or (R.autorizador=".$id." and R.estatus=2)) or ((R.director=".$id." and R.autorizador=".$id.") and (R.estatus=1 or R.estatus=2))");
		//$this->db->where('(solicita='.$id.') or (director='.$id.' and estatus=1) or (autorizador='.$id.' and estatus=2)')->get('Requisiciones')->result();
		
		/*$this->db->or_where('R.director',$colaborador->id);		
		$this->db->where('R.estatus',1);
		
		$this->db->or_where('R.autorizador',$colaborador->id);		
		$this->db->where('R.estatus',2);*/				
		
		$this->db->order_by("fecha_solicitud", "desc");
		
		return $this->db->get('Requisiciones R')->result();
	}

	function update($id,$datos){
		$datos['usuario_modificacion']=$this->session->userdata('id');
		$this->db->where('id',$id)->update('Requisiciones',$datos);
		if($this->db->affected_rows() == 1)
			return $id;
		else
			return false;
	}

	// Esta funcion evalua todas la requisiciones y cancela todas las que tienen un tiempo limite de existencias
	function expireRequisicion($time){
		
		/*$fecha="2016-05-14 00:00:00";
		$segundos= strtotime('now') - strtotime($fecha);
		$diferencia_dias=intval($segundos/60/60/24);*/
		
		$datos['estatus'] = 0;
		$datos['razon'] = "Requisición fuera del rango de espera";
		$this->db->where("((datediff(now(),fecha_solicitud))>".$time.") and ((estatus=1) or (estatus=2)) and (razon!='')")->update('Requisiciones',$datos);
		
		//$this->db->where()->update('Requisiciones',$datos)
		
		/*$datos['estatus'] = 5;
		$datos['razon'] = "Requisición fuera del rango de espera";
		$this->db->where("((datediff(now(),fecha_solicitud))>".$time.") and ((estatus=1) or (estatus=2)) and (razon='')")->update('Requisiciones',$datos);
		*/		
		//echo date('now');
		
	}

	/*function getByColaborador($colaborador) {
		return $this->db->where('solicita',$colaborador)->get('Requisiciones')->result();
	}

	function getPendientesByColaborador($colaborador) {
		$extra="";
		if($this->session->userdata('tipo') >= 3 && $this->session->userdata('area')==4)
			$extra=" or estatus in(3,7)";
		$this->db->where("(director=$colaborador and estatus=1) or (autorizador=$colaborador and estatus=2)$extra");
		return $this->db->get('Requisiciones')->num_rows();
	}*/
	
	function getRequisicionesPendenting($id){
		//
		return $this->db->where('((solicita='.$id.' and alerta=1 and (estatus=3 or estatus=4 or estatus=5 or estatus=8 or estatus=0)) or (director='.$id.' and estatus=1 and alerta=1) or (autorizador='.$id.' and estatus=2 and alerta=1)) or ((director='.$id.' and autorizador='.$id.') and (estatus=1 or estatus=2) and alerta=1)')->get('Requisiciones')->result();
		
	}
	
}