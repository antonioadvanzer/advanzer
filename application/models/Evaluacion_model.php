<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Evaluacion_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getComportamientoByCompetencia($competencia,$posicion) {
		$this->db->select('C.id,C.descripcion,C.competencia,CP.evalua');
		$this->db->where(array('C.competencia'=>$competencia,'CP.nivel_posicion'=>$posicion));
		$this->db->order_by('C.descripcion');
		$this->db->join('Comportamiento_Posicion CP','CP.comportamiento = C.id');
		return $this->db->get('Comportamientos C')->result();
	}

	function getCompetenciasByIndicador($indicador,$posicion) {
		$this->db->distinct();
		$this->db->select('C.id,C.nombre,C.descripcion');
		$this->db->from('Competencias C');
		$this->db->join('Comportamientos Co','Co.competencia = C.id');
		$this->db->join('Comportamiento_Posicion CP','CP.comportamiento = Co.id');
		$this->db->where(array('C.estatus'=>1,'C.indicador'=>$indicador,'CP.nivel_posicion'=>$posicion));
		$this->db->order_by('C.nombre','asc');
		return $this->db->get()->result();
	}

	function getIndicadoresByPosicion($posicion) {
		$this->db->distinct();
		$this->db->select('I.id,I.nombre');
		$this->db->from('Indicadores I');
		$this->db->join('Competencias C','C.indicador = I.id');
		$this->db->join('Comportamientos Co','Co.competencia = C.id');
		$this->db->join('Comportamiento_Posicion CP','Co.id = CP.comportamiento');
		//$this->db->order_by('I.nombre');
		$this->db->where(array('I.estatus'=>1,'C.estatus'=>1,'CP.nivel_posicion'=>$posicion));
		$this->db->order_by('I.nombre','asc');
		return $this->db->get()->result();
	}

	function getObjetivosByDominio($dominio,$area,$posicion) {
		$this->db->select('O.id,O.nombre,PO.valor,O.descripcion');
		$this->db->from('Objetivos O');
		$this->db->join('Objetivos_Areas OA','OA.objetivo = O.id');
		$this->db->join('Porcentajes_Objetivos PO','PO.objetivo = O.id');
		$this->db->where(array('O.dominio'=>$dominio,'OA.area'=>$area,'PO.nivel_posicion'=>$posicion,'O.estatus'=>1));
		$this->db->order_by('O.nombre','asc');
		return $this->db->get()->result();
	}

	function getMetricaByObjetivo($obj) {
		$this->db->from('Metricas');
		$this->db->where('objetivo',$obj);
		$this->db->order_by('valor','desc');
		return $this->db->get()->result();
	}

	function getResponsabilidadByArea($area) {
		$this->db->distinct();
		$this->db->select('D.id, D.nombre');
		$this->db->from('Areas A');
		$this->db->join('Objetivos_Areas OA','OA.area = A.id');
		$this->db->join('Objetivos O','O.id = OA.objetivo');
		$this->db->join('Dominios D','O.dominio = D.id');
		$this->db->order_by('D.nombre');
		$this->db->where(array('A.id'=>$area,'D.estatus'=>1,'A.estatus'=>1,'O.estatus'=>1));
		return $this->db->get()->result();
	}

	function getPerfil($area,$posicion) {
		$this->db->select('D.nombre dominio,O.descripcion,A.nombre area,O.nombre objetivo,O.id id_objetivo,PO.valor');
		$this->db->from('Areas A');
		$this->db->join('Objetivos_Areas OA','OA.area = A.id');
		$this->db->join('Objetivos O','OA.objetivo = O.id');
		$this->db->join('Dominios D','O.dominio = D.id');
		$this->db->join('Porcentajes_Objetivos PO','PO.objetivo = O.id');
		$this->db->where('O.estatus',1);
		if($posicion != null)
			$this->db->where('PO.posicion',$posicion);
		if($area != null)
			$this->db->where('A.id',$area);
		$this->db->order_by('D.nombre,O.nombre','asc');
		return $this->db->get()->result();

	}

	function getEvaluadores($tipo=0) {
		$this->db->select('Us.foto,Ev.id id,Us.nombre nombre,count(Ev.evaluado) as cantidad');
		$this->db->join('Users as Us','Us.id = Ev.evaluador');
		$this->db->where('Ev.estatus',0);
		if($tipo==1)//1=evaluacion 360
			$this->db->where('Ev.tipo',3);
		else
			$this->db->where('Ev.tipo !=',3);
		$this->db->group_by('Ev.evaluador');
		$this->db->order_by('Us.nombre','asc');
		return $this->db->get('Evaluadores as Ev');
	}

	function getByText($valor,$tipo) {
		$this->db->select('Us.foto,Ev.id id,Us.nombre nombre,count(Ev.evaluado) as cantidad');
		$this->db->join('Users as Us','Us.id = Ev.evaluador');
		$this->db->where('Ev.estatus',0);
		if($tipo==1)//1=evaluacion 360
			$this->db->where('Ev.tipo',3);
		else
			$this->db->where('Ev.tipo !=',3);

		$this->db->select('Us.foto,Ev.id id,Us.nombre nombre,count(Ev.evaluado) as cantidad');
		$this->db->join('Users as Us','Us.id = Ev.evaluador');
		$this->db->where('Ev.estatus',0);
		$this->db->where('Ev.360',0);
		$this->db->like('Us.nombre',$valor);
		$this->db->group_by('Ev.evaluador');
		$this->db->order_by('Us.nombre','asc');
		return $this->db->get('Evaluadores as Ev')->result();
	}

	function getCountUsers() {
		return $this->db->where('estatus',1)->count_all_results('Users');
	}

	function getEvaluacionesByEvaluador($evaluador) {
		$this->db->select('U.id,U.foto,U.nombre,U.nomina,A.nombre area,P.nombre posicion,T.nombre track,E.tipo,E.estatus');
		$this->db->from('Users U');
		$this->db->join('Areas A','A.id = U.area','LEFT OUTER');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		$this->db->join('Evaluadores E','E.evaluado = U.id','LEFT OUTER');
		$this->db->where(array('E.evaluador'=>$evaluador,'U.estatus'=>1,'E.estatus !='=>2));
		$this->db->order_by('U.nombre','asc');
		return $this->db->get()->result();
	}

	function getEvaluados($limit,$start,$tipo=3) {
		$this->db->limit($limit,$start);
		$this->db->select('U.id,U.foto,U.email,U.nombre,U.nomina,P.nombre posicion,T.nombre track,RE.total,
			RE.rating,F.id,F.estatus feedback');
		$this->db->from('Users U');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		$this->db->join('Resultados_Evaluacion RE','RE.colaborador = U.id','LEFT OUTER');
		$this->db->join('Feedbacks F','F.resultado = RE.id','LEFT OUTER');
		$this->db->where('U.estatus',1);
		$this->db->order_by('U.nombre','asc');
		$result = $this->db->get()->result();
		foreach ($result as $colaborador) {
			$this->db->select('U.id,U.foto,U.nombre,RC.total competencia,RR.total responsabilidad');
			$this->db->from('Users U');
			$this->db->join('Evaluadores E','E.evaluado = U.id','LEFT OUTER');
			$this->db->join('Resultados_ev_Competencia RC','RC.asignacion = E.id','LEFT OUTER');
			$this->db->join('Resultados_ev_Responsabilidad RR','RR.asignacion = E.id','LEFT OUTER');
			$this->db->join('Evaluaciones Ev','Ev.id = E.evaluacion','LEFT OUTER');
			$this->db->where(array('E.tipo <'=>$tipo,'Ev.estatus !='=>0,'E.estatus !='=>0));
			$colaborador->evaluadores = $this->db->get()->result();
		}
		return $result;
	}

	function getPagination($limit, $start,$tipo=0) {
		$this->db->limit($limit,$start);
		$this->db->select('Us.foto,Ev.evaluador id,Us.nombre nombre,count(Ev.evaluado) as cantidad');
		$this->db->join('Users as Us','Us.id = Ev.evaluador');
		$this->db->where(array('Ev.estatus'=>0,'Us.estatus'=>1));
		if($tipo==1)//1=evaluacion 360
			$this->db->where('Ev.tipo',3);
		else
			$this->db->where('Ev.tipo !=',3);
		$this->db->group_by('Ev.evaluador');
		$this->db->order_by('Us.nombre','asc');
		return $this->db->get('Evaluadores as Ev')->result();
	}

	function getByEvaluador($evaluador,$tipo=0) {
		$this->db->select('Us.id,Us.nombre,P.nombre posicion,T.nombre track,Ev.tipo tipo');
		$this->db->where('evaluador',$evaluador);
		if($tipo==1)//1=evaluacion 360
			$this->db->where('Ev.tipo',3);
		else
			$this->db->where('Ev.tipo !=',3);
		$this->db->from('Evaluadores Ev');
		$this->db->join('Users Us','Ev.evaluado = Us.id');
		$this->db->join('Posicion_Track PT','PT.id = Us.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		return $this->db->get()->result();
	}

	function getNotByEvaluador($evaluador,$ignore,$tipo=0) {
		$empresa=$this->db->select('empresa')->from('Users')->where('id',$evaluador)->get()->first_row()->empresa;
		if(count($ignore)>0){
			$array_temp=array();
			foreach ($ignore as $temp) 
				array_push($array_temp, $temp->id);
			$this->db->where_not_in('Us.id',$array_temp);
		}
		if($tipo == 1)
			$this->db->where('P.nivel <=',5);

		$this->db->select('Us.id,Us.nombre,P.nombre posicion,T.nombre track');
		$this->db->where(array('Us.id !='=>$evaluador,'Us.estatus'=>1,'Us.empresa'=>$empresa));
		$this->db->from('Users Us');
		$this->db->join('Posicion_Track PT','PT.id = Us.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		return $this->db->order_by('Us.nombre')->get()->result();
	}

	function addColaboradorToEvaluador($evaluador,$colaborador,$tipo) {
		$this->db->insert('Evaluadores',array('evaluador'=>$evaluador,'evaluado'=>$colaborador,'tipo'=>$tipo));
		if($this->db->insert_id())
			return true;
		else
			return false;
	}

	function delColaboradorFromEvaluador($evaluador,$colaborador,$tipo) {
		if($tipo!=3)
			$this->db->where('tipo !=',3);
		else
			$this->db->where('tipo',3);
		$this->db->where(array('evaluador'=>$evaluador,'evaluado'=>$colaborador));
		$this->db->delete('Evaluadores');
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function getEvaluacionesSinAplicar() {
		$this->db->where('estatus <',3);
		$this->db->order_by('nombre','desc');
		return $this->db->get('Evaluaciones')->result();
	}

	function gestionar($id,$datos) {
		$this->db->where('id',$id);
		$this->db->update('Evaluaciones',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function getEvaluacionById($id) {
		$this->db->where('id',$id);
		return $this->db->get('Evaluaciones')->first_row();
	}

	function create($datos) {
		$this->db->insert('Evaluaciones',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}
}