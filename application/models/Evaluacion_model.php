<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Evaluacion_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getComportamientoByCompetencia($competencia,$posicion,$asignacion=null) {
		$this->db->select('C.id,C.descripcion,C.competencia,CP.evalua');
		$this->db->where(array('C.competencia'=>$competencia,'CP.nivel_posicion'=>$posicion));
		$this->db->order_by('C.descripcion');
		$this->db->join('Comportamiento_Posicion CP','CP.comportamiento = C.id');
		if($asignacion!=null){
			$this->db->select('DC.respuesta');
			$this->db->join('Detalle_ev_Competencia DC','DC.comportamiento=C.id','LEFT OUTER');
			$this->db->where('DC.asignacion',$asignacion);
		}
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
		$this->db->where(array('I.estatus'=>1,'C.estatus'=>1,'CP.nivel_posicion'=>$posicion));
		$this->db->order_by('I.nombre','asc');
		return $this->db->get()->result();
	}

	function getObjetivosByDominio($dominio,$area,$posicion,$asignacion=null) {
		$this->db->select('O.id,O.nombre,PO.valor,O.descripcion');
		$this->db->from('Objetivos O');
		$this->db->join('Objetivos_Areas OA','OA.objetivo = O.id');
		$this->db->join('Porcentajes_Objetivos PO','PO.objetivo = O.id');
		if($asignacion!=null){
			$this->db->select('M.valor');
			$this->db->join('Detalle_Evaluacion DE','DE.objetivo=O.id','LEFT OUTER');
			$this->db->join('Metricas M','M.id = DE.metrica','LEFT OUTER');
			$this->db->where('DE.asignacion',$asignacion);
		}
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
		$this->db->select('U.id,U.foto,U.nombre,U.nomina,A.nombre area,P.nombre posicion,T.nombre track,E.tipo,E.estatus,E.id asignacion');
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

	function getPagination() {
		$this->db->select('id,foto,nombre');
		$this->db->group_by('id');
		$this->db->order_by('nombre');
		$result = $this->db->get('Users')->result();
		foreach ($result as $user) :
			$user->total_evaluadores = $this->db->select('count(evaluador) total')
			->where(array('evaluado'=>$user->id,'estatus <'=>2))->get('Evaluadores')->first_row()->total;
		endforeach;
		return $result;
	}

	function getInfoLider($lider) {
		$this->db->select('Us.id,Us.nombre,P.nombre posicion,T.nombre track')->from('Users Us');
		$this->db->join('Posicion_Track PT','PT.id = Us.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		$this->db->where('Us.id',$lider);
		return $this->db->get()->first_row();
	}

	function getParticipantesByEvaluacion($evaluacion) {
		$this->db->select('Us.id,Us.nombre,P.nombre posicion,T.nombre track')->from('Users Us');
		$this->db->join('Posicion_Track PT','PT.id = Us.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		$this->db->join('Evaluadores E','E.evaluado = Us.id');
		$this->db->join('Evaluaciones Ev','Ev.id = E.evaluacion');
		$this->db->where('Ev.id',$evaluacion);
		return $this->db->get()->result();
	}

	function getEvaluadoresByColaborador($colaborador) {
		$this->db->select('Ev.evaluador id,Us.nombre,P.nombre posicion,T.nombre track');
		$this->db->where('evaluado',$colaborador);
		$this->db->from('Evaluadores Ev');
		$this->db->join('Users Us','Ev.evaluador = Us.id');
		$this->db->join('Posicion_Track PT','PT.id = Us.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		return $this->db->get()->result();
	}

	function getNotEvaluadoresByColaborador($colaborador,$ignore) {
		$empresa=$this->db->select('empresa')->from('Users')->where('id',$colaborador)->get()->first_row()->empresa;
		if(count($ignore)>0){
			$array_temp=array();
			foreach ($ignore as $temp) 
				array_push($array_temp, $temp->id);
			$this->db->where_not_in('Us.id',$array_temp);
		}

		$this->db->select('Us.id,Us.nombre,P.nombre posicion,T.nombre track');
		$this->db->where(array('Us.id !='=>$colaborador,'Us.estatus'=>1,'Us.empresa'=>$empresa));
		$this->db->from('Users Us');
		$this->db->join('Posicion_Track PT','PT.id = Us.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		return $this->db->order_by('Us.nombre')->get()->result();
	}

	function addEvaluadorToColaborador($datos) {
		if($this->db->where($datos)->where('estatus !=',2)->get('Evaluadores')->num_rows() == 0)
			$this->db->insert('Evaluadores',$datos);
	}

	function delEvaluadorFromColaborador($datos) {
		if($this->db->where($datos)->where('estatus !=',2)->get('Evaluadores')->num_rows() != 0)
			$this->db->where($datos)->where('estatus !=',2)->delete('Evaluadores');
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
		return $this->db->where('id',$id)->get('Evaluaciones')->first_row();
	}

	function eraseByEvaluador($evaluacion,$evaluador) {
		$this->db->where(array('evaluacion'=>$evaluacion,'evaluador'=>$evaluador))->delete('Evaluadores');
		echo $this->db->affected_rows()." borradas";
	}

	function updateLider($evaluacion,$lider) {
		$this->db->where('id',$evaluacion)->update('Evaluaciones',array('lider'=>$lider));
	}

	function getEvaluacionByAsignacion($asignacion) {
		$this->db->select('id,estatus,tipo,evaluador,evaluado');
		$this->db->from('Evaluadores');
		$this->db->where('id',$asignacion);
		$result = $this->db->get()->first_row();
		$posicion=$this->getPosicionByColaborador($result->evaluado);
		foreach ($result->indicadores = $this->getIndicadoresByPosicion($posicion) as $indicador) :
			foreach ($indicador->competencias = $this->getCompetenciasByIndicador($indicador->id,$posicion) as $competencia ) :
				$competencia->comportamientos = $this->getComportamientoByCompetencia($competencia->id,$posicion,$asignacion);
			endforeach;
		endforeach;
		switch ($result->tipo) {
			case 0:
				$area = $this->getAreaByColaborador($result->evaluado);
				foreach ($result->dominios=$this->getResponsabilidadByArea($area) as $dominio) :
					foreach ($dominio->responsabilidades=$this->getObjetivosByDominio($dominio->id,$area,$posicion,$asignacion) as $responsabilidad) :
						$responsabilidad->metricas = $this->getMetricaByObjetivo($responsabilidad->id);
					endforeach;
				endforeach;
				break;
		}
		return $result;
	}

	function guardaMetrica($asignacion,$metrica,$objetivo) {
		$id_m=$this->db->select('id')->where(array('objetivo'=>$objetivo,'valor'=>$metrica))->get('Metricas')->first_row()->id;
		$this->db->where(array('asignacion'=>$asignacion,'objetivo'=>$objetivo))
			->update('Detalle_Evaluacion',array('metrica'=>$id_m));
		if($this->db->affected_rows() != 1)
			return false;
		return true;
	}

	function guardaComportamiento($asignacion,$respuesta,$comportamiento) {
		$this->db->where(array('asignacion'=>$asignacion,'comportamiento'=>$comportamiento))
			->update('Detalle_ev_Competencia',array('respuesta'=>$respuesta));
		if($this->db->affected_rows() != 1)
			return false;
		$this->ch_estatus($asignacion);
		return true;
	}

	function ch_estatus($asignacion,$estatus=1) {
		$this->db->where('id',$asignacion)->update('Evaluadores',array('estatus'=>$estatus));
	}

	function getAreaByColaborador($evaluado) {
		return $this->db->where('id',$evaluado)->select('area')->from('Users')->get()->first_row()->area;
	}

	function getPosicionByColaborador($evaluado) {
		$this->db->select('P.nivel')->from('Users U')->join('Posicion_Track PT','PT.id = U.posicion_track');
		$this->db->join('Posiciones P','P.id = PT.posicion');
		return $this->db->where('U.id',$evaluado)->get()->first_row()->nivel;
	}

	function searchAsignacionById($id) {
		return $this->db->where('id',$id)->get('Evaluadores')->first_row();
	}

	function isAsignacionEmpty($asignacion) {
		if ($this->searchAsignacionById($asignacion)->tipo == 0) {
			if($this->db->where('asignacion',$asignacion)->get('Detalle_Evaluacion')->num_rows() > 0)
				return false;
		}else
			if($this->db->where('asignacion',$asignacion)->get('Detalle_ev_Competencia')->num_rows() > 0)
				return false;
		return true;
	}

	function fillAsignacion($asignacion) {
		$tipo = $this->searchAsignacionById($asignacion)->tipo;
		$this->db->trans_begin();
		if($tipo == 3 || $tipo == 1 || $tipo==0){
			//fill Competencias
			$this->db->select('C.id');
			$this->db->from('Evaluadores E');
			$this->db->join('Users U','E.evaluado = U.id');
			$this->db->join('Posicion_Track PT','PT.id = U.posicion_track');
			$this->db->join('Posiciones P','P.id = PT.posicion');
			$this->db->join('Comportamiento_Posicion CP','CP.nivel_posicion = P.nivel');
			$this->db->join('Comportamientos C','C.id = CP.comportamiento');
			$this->db->where('E.id',$asignacion);
			$comportamientos = $this->db->get()->result();
			foreach ($comportamientos as $comportamiento) :
				$this->db->insert('Detalle_ev_Competencia',array('comportamiento'=>$comportamiento->id,
					'asignacion'=>$asignacion));
			endforeach;
		}
		if($tipo==0){
			//fill Responsabilidades
			$this->db->select('O.id');
			$this->db->from('Evaluadores E');
			$this->db->join('Users U','E.evaluado = U.id');
			$this->db->join('Objetivos_Areas OA','OA.area = U.area');
			$this->db->join('Objetivos O','O.id = OA.objetivo');
			$this->db->where('E.id',$asignacion);
			$objetivos = $this->db->get()->result();
			foreach ($objetivos as $objetivo) :
				$this->db->insert('Detalle_Evaluacion',array('asignacion'=>$asignacion,'objetivo'=>$objetivo->id));
			endforeach;
		}

		if($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}

	function finalizar_evaluacion($asignacion,$tipo) {
		if($this->is_filled_evaluacion($asignacion,$tipo)){
			if($this->ch_estatus($asignacion,2))
				return true;
		}
		return false;
	}

	function is_filled_evaluacion($asignacion,$tipo) {
		if($tipo=="responsabilidad"){
			if($this->db->where(array('asignacion'=>$asignacion,'metrica'=>0))
				->from('Detalle_Evaluacion')->count_all_results() == 0)
				return true;
		}else{
			if($this->db->where(array('asignacion'=>$asignacion,'respuesta'=>0))
				->from('Detalle_ev_Competencia')->count_all_results() == 0)
				return true;
		}
		return false;
	}

	function create($datos) {
		$this->db->insert('Evaluaciones',$datos);
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		else
			return false;
	}
}