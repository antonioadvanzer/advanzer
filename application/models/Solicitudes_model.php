<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Solicitudes_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getAll() {
		return $this->db->get('Solicitudes')->result();
	}

	function getSolicitudById($id) {
		$result = $this->db->where('id',$id)->get('Solicitudes')->first_row();
		$result->nombre_solicita=$this->db->where('id',$result->colaborador)->get('Users')->first_row()->nombre;
		$result->nombre_autorizador=$this->db->where('id',$result->autorizador)->get('Users')->first_row()->nombre;
		if($result->tipo == 3):
				$result->detalle = $this->db->where('solicitud',$result->id)->get('Detalle_Viaticos')->first_row();
			endif;
		return $result;
	}

	function getViaticosInfo($datos) {
		$result = $this->db->where($datos)->join('Detalle_Viaticos','Detalle_Viaticos.solicitud=Solicitudes.id')->get('Solicitudes')->first_row();
		return $result;
	}

	function getDiasDisponibles($colaborador) {
		$result = $this->db->select('dias_acumulados')->from('Vacaciones')->where(array('colaborador'=>$colaborador,'dias_acumulados <'=>0))->get();
		if($result->num_rows() == 1)
			return $result->first_row()->dias_acumulados;
		else
			return 0;
	}

	function getAcumulados($colaborador) {
		$result = $this->db->from('Vacaciones')->where('colaborador',$colaborador)->get();
		if($result->num_rows() == 1)
			return $result->first_row();
		else
			return false;
	}

	function registra_solicitud($datos) {
		$this->db->insert('Solicitudes',$datos);
		return $this->db->insert_id();
	}

	function update_detalle_viaticos($solicitud,$datos) {
		$result=$this->db->where('solicitud',$solicitud)->get('Detalle_Viaticos');
		if($result->num_rows() == 1)
			$this->db->update('Detalle_Viaticos',$datos);
		else{
			$datos['solicitud']=$solicitud;
			$this->db->insert('Detalle_Viaticos',$datos);
		}
	}

	function actualiza_dias_vacaciones($colaborador,$datos) {
		$result = $this->db->where('colaborador',$colaborador)->get('Vacaciones');
		if($result->num_rows() == 1)
			$this->db->where('id',$result->first_row()->id)->update('Vacaciones',$datos);
		else{
			$datos['colaborador']=$colaborador;
			$this->db->insert('Vacaciones',$datos);
		}
	}

	function getByColaborador($colaborador,$tipo) {
		if($tipo==2 || $tipo==3)
			$tipo='2 or S.tipo=3';
		elseif($tipo==4){
			$this->db->select('*')->join('Detalle_Viaticos as DV ','solicitud=S.id');
		}
		$result = $this->db->where('(S.tipo='.$tipo.') and ((S.colaborador = '.$colaborador.' and S.regresa >="'.date("Y-m-d").'" and S.estatus != 3) or (S.colaborador = '.$colaborador.' and S.estatus = 1))')->get('Solicitudes S');
		if($result->num_rows() > 0)
			return $result->first_row();
		else
			return false;
	}

	function getByAutorizador($colaborador) {
		$this->db->select('Sv.id,Sv.dias,Sv.desde,Sv.hasta,Sv.regresa,Sv.fecha_solicitud,Sv.observaciones,U.nombre')->from('Solicitudes Sv')
			->join('Users U','U.id = Sv.colaborador')
			->where(array('Sv.autorizador'=>$colaborador,'Sv.estatus'=>1,'Sv.desde >='=>date('Y-m-d'),'Sv.tipo'=>1));
		$result = $this->db->get();
		if($result->num_rows() > 0)
			return $result->result();
		else
			return false;
	}

	function update_solicitud($id,$datos) {
		$this->db->where('id',$id)->update('Solicitudes',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function getVacacionesExpired() {
		$this->db->where('vencimiento_uno <',date('Y-m-d'));
		return $this->db->get('Vacaciones')->result();
	}
}