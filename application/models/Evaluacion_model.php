<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Evaluacion_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getComportamientoByCompetencia($competencia,$posicion,$asignacion=null) {
		$this->db->select('C.id,C.descripcion,C.competencia')->from('Comportamientos C');
		$this->db->join('Comportamiento_Posicion CP','CP.comportamiento = C.id','LEFT OUTER');
		$this->db->where(array('C.competencia'=>$competencia,'CP.nivel_posicion'=>$posicion));
		$this->db->order_by('C.descripcion');
		$result = $this->db->get()->result();
		foreach ($result as $comportamiento) :
			$res = $this->db->from('Detalle_ev_Competencia')->
				where(array('asignacion'=>$asignacion,'comportamiento'=>$comportamiento->id))->get();
			($res->num_rows() == 1) ? $comportamiento->respuesta = $res->first_row()->respuesta : $comportamiento->respuesta = 0;
		endforeach;
		return $result;
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

	function getObjetivosByDominio($dominio,$area,$posicion) {
		$this->db->select('O.id,O.nombre,PO.valor,O.descripcion,O.tipo');
		$this->db->from('Objetivos O');
		$this->db->join('Objetivos_Areas OA','OA.objetivo = O.id','LEFT OUTER');
		$this->db->join('Porcentajes_Objetivos PO','PO.objetivo_area = OA.id','LEFT OUTER');
		$this->db->where(array('O.dominio'=>$dominio,'OA.area'=>$area,'PO.nivel_posicion'=>$posicion,'O.estatus'=>1));
		$this->db->order_by('O.tipo,O.nombre');
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
		$this->db->select('U.id,U.foto,U.nombre,U.nomina,A.nombre area,P.nombre posicion,Ev.tipo,E.estatus,E.id asignacion');
		$this->db->from('Users U');
		$this->db->join('Areas A','A.id = U.area','LEFT OUTER');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		$this->db->join('Evaluadores E','E.evaluado = U.id','LEFT OUTER');
		$this->db->join('Evaluaciones Ev','Ev.id = E.evaluacion','LEFT OUTER');
		$this->db->where(array('E.evaluador'=>$evaluador,'U.estatus'=>1,'E.estatus !='=>2));
		$this->db->order_by('U.nombre','asc');
		return $this->db->get()->result();
	}

	function getEvaluados() {
		$this->db->select('U.id,U.foto,U.nombre,U.nomina,P.nombre posicion,T.nombre track');
		$this->db->from('Users U');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		$this->db->where('U.estatus',1);
		$this->db->order_by('U.nombre');
		$result = $this->db->get()->result();
		foreach ($result as $colaborador) : // getEvaluadores
			$colaborador = $this->getResultadosByColaborador($colaborador);
		endforeach;
		return $result;
	}

	function updateRating($where,$datos) {
		$this->db->where($where)->update('Resultados_Evaluacion',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

	function updateFeedbacker($where,$datos) {
		$res = $this->db->where($where)->get('Resultados_Evaluacion')->first_row();
		$this->db->where('resultado',$res->id)->update('Feedbacks',$datos);
	}

	function getResultadosByColaborador($colaborador) {
		$evaluacion=$this->getEvaluacionAnual();
		$res=$this->db->from('Resultados_Evaluacion')->where(array('colaborador'=>$colaborador->id,'evaluacion'=>$evaluacion))->get();
		if($res->num_rows() == 1){
			$colaborador->rating = $res->first_row()->rating;
			$colaborador->total = $res->first_row()->total;
			$res = $this->db->select('F.id,F.estatus,F.feedbacker,F.contenido,U.nombre')->from('Feedbacks F')
				->join('Users U','U.id = F.feedbacker')
				->where(array('F.resultado'=>$res->first_row()->id))->get();
			($res->num_rows() == 1) ? $colaborador->feedback = $res->first_row() : $colaborador->feedback = null;
		}else{
			$colaborador->rating = null;
			$colaborador->total = 0;
			$colaborador->feedback = null;
		}
		//obtener evaluacion360 si es de nivel 3-4-5
		$posicion=$this->getPosicionByColaborador($colaborador->id);
		if($posicion >=3 && $posicion <= 5){
			$jefe=$this->db->select('jefe')->from('Users')->where('id',$colaborador->id)->get()->first_row()->jefe;
			$this->db->select('U.id,U.foto,U.nombre,E.id asignacion')->from('Users U');
			$this->db->join('Evaluadores E','E.evaluador = U.id');
			$this->db->join('Evaluaciones Ev','Ev.id = E.evaluacion','LEFT OUTER');
			$this->db->where(array('Ev.estatus !='=>0,'Ev.id'=>$evaluacion,'E.evaluado'=>$colaborador->id,'E.evaluador !='=>$jefe,
				'E.evaluador !='=>$colaborador->id));
			$colaborador->evaluadores360 = $this->db->get()->result();
			$ignore=array();
			foreach ($colaborador->evaluadores360 as $evaluador) :
				array_push($ignore, $evaluador->id);
				$res=$this->db->from('Resultados_ev_Competencia')->where('asignacion',$evaluador->asignacion)->get();
				($res->num_rows() == 1) ? $evaluador->competencia = $res->first_row()->total : $evaluador->competencia = null;
			endforeach;
			if (!empty($ignore)) 
				$this->db->where_not_in('U.id',$ignore);
		}
		//evaluadores
		$this->db->select('U.id,U.foto,U.nombre,E.id asignacion');
		$this->db->from('Users U');
		$this->db->join('Evaluadores E','E.evaluador = U.id');
		$this->db->join('Evaluaciones Ev','Ev.id = E.evaluacion','LEFT OUTER');
		$this->db->where(array('Ev.estatus !='=>0,'Ev.id'=>$evaluacion,'E.evaluado'=>$colaborador->id,'E.evaluador !='=>$colaborador->id));
		$colaborador->evaluadores = $this->db->get()->result();
		foreach ($colaborador->evaluadores as $evaluador) :
			$res=$this->db->from('Resultados_ev_Competencia')->where('asignacion',$evaluador->asignacion)->get();
			($res->num_rows() == 1) ? $evaluador->competencia = $res->first_row()->total : $evaluador->competencia = null;
			$res=$this->db->from('Resultados_ev_Responsabilidad')->where('asignacion',$evaluador->asignacion)->get();
			($res->num_rows() == 1) ? $evaluador->responsabilidad = $res->first_row()->total : $evaluador->responsabilidad = null;
			$asignacion = $evaluador->asignacion;
		endforeach;
		//autoevaluacion
		$this->db->from('Evaluadores')->where(array('evaluador'=>$colaborador->id,'evaluado'=>$colaborador->id,'evaluacion'=>$evaluacion));
		$res = $this->db->get();
		if($res->num_rows() ==1){
			$res=$this->db->from('Resultados_ev_Competencia')->where('asignacion',$res->first_row()->id)->get();
			($res->num_rows() == 1) ? $colaborador->autoevaluacion = $res->first_row()->total : $colaborador->autoevaluacion = null;
		}else
			$colaborador->autoevaluacion = null;
		return $colaborador;
	}

	function calculaResultado($asignacion) {
		$posicion=$this->getPosicionByColaborador($asignacion->evaluado);
		$jefe=$this->db->select('jefe')->from('Users')->where('id',$asignacion->evaluado)->get()->first_row()->jefe;
		$competencia=0;
		$responsabilidad=0;
		//si es de gerente a director se evalúa 360
		if($posicion >= 3 && $posicion <= 5){
			$this->db->select('AVG(RC.total) total360')->from('Resultados_ev_Competencia RC');
			$this->db->join('Evaluadores Ev','Ev.id = RC.asignacion');
			$this->db->where(array('Ev.evaluado'=>$asignacion->evaluado,'Ev.evaluacion'=>$asignacion->evaluacion,'Ev.evaluador !='=>$jefe,
				'Ev.evaluador !='=>$asignacion->evaluado));
			$res = $this->db->get();
			if($res->num_rows() == 1)
				(double)$competencia += (double)($res->first_row()->total360)*0.1;
		}
		//evaluacion del jefe directo y líderes de proyecto
		$this->db->select('RC.total')->from('Resultados_ev_Competencia RC');
		$this->db->join('Evaluadores Ev','Ev.id = RC.asignacion');
		$this->db->where(array('Ev.evaluado'=>$asignacion->evaluado,'Ev.evaluacion'=>$asignacion->evaluacion,'Ev.evaluador'=>$jefe));
		$res=$this->db->get();
		if($res->num_rows() == 1)
			if($posicion >= 3 && $posicion <= 5)
				(double)$competencia += (double)($res->first_row()->total)*0.1;
			else
				(double)$competencia += (double)($res->first_row()->total)*0.15;
		//autoevaluación
		$this->db->select('RC.total')->from('Resultados_ev_Competencia RC');
		$this->db->join('Evaluadores Ev','Ev.id = RC.asignacion');
		$this->db->where(array('Ev.evaluado'=>$asignacion->evaluado,'Ev.evaluacion'=>$asignacion->evaluacion,'Ev.evaluador'=>$asignacion->evaluado));
		$res=$this->db->get();
		if($res->num_rows() == 1)
			if($posicion >= 3 && $posicion <= 5)
				(double)$competencia += ($res->first_row()->total)*0.1;
			else
				(double)$competencia += ($res->first_row()->total)*0.15;
		$this->db->select('AVG(RR.total) total')->from('Resultados_ev_Responsabilidad RR');
		$this->db->join('Evaluadores Ev','Ev.id = RR.asignacion');
		$this->db->where(array('Ev.evaluado'=>$asignacion->evaluado,'Ev.evaluacion'=>$asignacion->evaluacion));
		$res=$this->db->get();
		if($res->num_rows() == 1)
			(double)$responsabilidad += ($res->first_row()->total)*0.7;

		(double)$total = $responsabilidad+$competencia;
		$res = $this->db->where(array('evaluacion'=>$asignacion->evaluacion,'colaborador'=>$asignacion->evaluado))->get('Resultados_Evaluacion');
		if($res->num_rows() == 1){
			$id_r = $res->first_row()->id;
			$this->db->where('id',$id_r)->update('Resultados_Evaluacion',array('total'=>$total));
		}
		else{
			$this->db->insert('Resultados_Evaluacion',array('evaluacion'=>$asignacion->evaluacion,'colaborador'=>$asignacion->evaluado,'total'=>$total));
			$id_r = $this->db->insert_id();
		}
		// verificar que haya registrado un feedbacker
		$res = $this->db->where('resultado',$id_r)->get('Feedbacks');
		if($res->num_rows() == 0)
			$this->db->insert('Feedbacks',array('resultado'=>$id_r,'feedbacker'=>$jefe));
	}

	function getPagination() {
		$this->db->select('U.id,U.foto,U.nombre,A.nombre area');
		$this->db->join('Areas A','A.id = U.area');
		$this->db->group_by('U.id');
		$this->db->order_by('U.nombre');
		$result = $this->db->get('Users U')->result();
		$evaluacion=$this->getEvaluacionAnual();
		foreach ($result as $user) :
			$user->total_evaluadores = $this->db->select('count(evaluador) total')
			->where(array('evaluado'=>$user->id,'estatus <'=>2,'evaluacion'=>$evaluacion))->get('Evaluadores')->first_row()->total;
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
		$evaluacion=$this->getEvaluacionAnual();
		$this->db->select('Ev.evaluador id,Us.nombre,P.nombre posicion,T.nombre track');
		$this->db->where(array('evaluado'=>$colaborador,'evaluacion'=>$evaluacion,'evaluador !='=>$colaborador));
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
		if($this->db->where($datos)->get('Evaluadores')->num_rows() == 0)
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

	function getRespuestaByAsignacionResponsabilidad($asignacion,$objetivo) {
		$result = $this->db->from('Detalle_Evaluacion')->where(array('asignacion'=>$asignacion,'objetivo'=>$objetivo))->get();
		if($result->num_rows() == 1){
			$id_m = $result->first_row()->metrica;
			return $this->db->from('Metricas')->where('id',$id_m)->get()->first_row()->valor;
		}else
			return 0;
	}

	function getEvaluacionByAsignacion($asignacion) {
		$result = $this->searchAsignacionById($asignacion);
		$posicion=$this->getPosicionByColaborador($result->evaluado);
		foreach ($result->indicadores = $this->getIndicadoresByPosicion($posicion) as $indicador) :
			foreach ($indicador->competencias = $this->getCompetenciasByIndicador($indicador->id,$posicion) as $competencia ) :
				$competencia->comportamientos = $this->getComportamientoByCompetencia($competencia->id,$posicion,$asignacion);
			endforeach;
		endforeach;
		$jefe=$this->db->select('jefe')->from('Users')->where('id',$result->evaluado)->get()->first_row()->jefe;
		if($jefe == $result->evaluador){
			$area = $this->getAreaByColaborador($result->evaluado);
			foreach ($result->dominios=$this->getResponsabilidadByArea($area) as $dominio) :
				foreach ($dominio->responsabilidades=$this->getObjetivosByDominio($dominio->id,$area,$posicion) as $responsabilidad) :
					$responsabilidad->respuesta = $this->getRespuestaByAsignacionResponsabilidad($asignacion,$responsabilidad->id);
					$responsabilidad->metricas = $this->getMetricaByObjetivo($responsabilidad->id);
				endforeach;
			endforeach;
		}
		return $result;
	}

	function guardaMetrica($asignacion,$metrica,$objetivo) {
		$id_m=$this->db->select('id')->where(array('objetivo'=>$objetivo,'valor'=>$metrica))->get('Metricas')->first_row()->id;
		$result = $this->db->from('Detalle_Evaluacion')->where(array('objetivo'=>$objetivo,'asignacion'=>$asignacion))->get();
		if($result->num_rows() == 1){
			$id_detalle=$result->first_row()->id;
			$this->db->where(array('asignacion'=>$asignacion,'objetivo'=>$objetivo))->update('Detalle_Evaluacion',array('metrica'=>$id_m));
		}else
			$this->db->insert('Detalle_Evaluacion',array('asignacion'=>$asignacion,'objetivo'=>$objetivo,'metrica'=>$id_m));
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

	function guardaComportamiento($asignacion,$respuesta,$comportamiento) {
		$result = $this->db->from('Detalle_ev_Competencia')->where(array('asignacion'=>$asignacion,'comportamiento'=>$comportamiento))->get();
		if($result->num_rows() == 1){
			$id_detalle=$result->first_row()->id;
			$this->db->where(array('asignacion'=>$asignacion,'comportamiento'=>$comportamiento))
				->update('Detalle_ev_Competencia',array('respuesta'=>$respuesta));
		}else
			$this->db->insert('Detalle_ev_Competencia',array('respuesta'=>$respuesta,'asignacion'=>$asignacion,'comportamiento'=>$comportamiento));
		if($this->db->affected_rows() == 1){
			$this->ch_estatus($asignacion);
			return true;
		}
		return false;
	}

	function ch_estatus($asignacion,$estatus=1) {
		$this->db->where('id',$asignacion)->update('Evaluadores',array('estatus'=>$estatus));
		if($this->db->affected_rows() == 1)
			return true;
		return false;
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
		return $this->db->select('E.id,Ev.tipo,E.evaluador,E.evaluado,E.estatus,Ev.id evaluacion')->from('Evaluadores E')
			->join('Evaluaciones Ev','Ev.id=E.evaluacion')->where('E.id',$id)->get()->first_row();
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

	function genera_autoevaluacion($evaluacion,$colaborador) {
		$result = $this->db->from('Evaluadores')->where(array('evaluador'=>$colaborador,'evaluado'=>$colaborador,'evaluacion'=>$evaluacion))->get();
		if($result->num_rows() == 0)
			$this->db->insert('Evaluadores',array('evaluador'=>$colaborador,'evaluado'=>$colaborador,'evaluacion'=>$evaluacion));
	}

	function finalizar_evaluacion($asignacion,$tipo) {
		$info = $this->searchAsignacionById($asignacion);
		$posicion = $this->getPosicionByColaborador($info->evaluado);
		$area = $this->getAreaByColaborador($info->evaluado);
		$jefe=$this->db->select('jefe')->from('Users')->where('id',$info->evaluado)->get()->first_row()->jefe;
		switch ($tipo) { //tipo 1 = anual
			case 1:
				if($jefe == $info->evaluador) { //si el evaluador es el jefe, guarda las responsabilidades
					// tomamos las responsabilidades de la tabla detalles para hacer los calculos
					$total = $this->db->select('SUM(PO.valor/100*M.valor) total')->from('Detalle_Evaluacion DE')
						->join('Objetivos O','O.id = DE.objetivo')->join('Objetivos_Areas OA','OA.objetivo = O.id')
						->join('Porcentajes_Objetivos PO','PO.objetivo_area = OA.id')
						->join('Metricas M','M.id = DE.metrica')
						->where(array('DE.asignacion'=>$asignacion,'PO.nivel_posicion'=>$posicion,'OA.area'=>$area))->get()->first_row()->total;
					$this->db->insert('Resultados_ev_Responsabilidad',array('asignacion'=>$asignacion,'total'=>$total));
				}
				$total = $this->db->select('AVG(DC.respuesta) total')->from('Detalle_ev_Competencia DC')
					->join('Comportamientos C','C.id = DC.comportamiento')
					->join('Comportamiento_Posicion CP','CP.comportamiento = C.id')
					->where(array('DC.asignacion'=>$asignacion,'CP.nivel_posicion'=>$posicion))->get()->first_row()->total;
				$this->db->insert('Resultados_ev_Competencia',array('asignacion'=>$asignacion,'total'=>$total));
				break;
		}
		$this->calculaResultado($info);
		if($this->ch_estatus($asignacion,2))
			return true;
		return false;
	}

	function create($datos) {
		$this->db->insert('Evaluaciones',$datos);
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		else
			return false;
	}

	function getEvaluacionAnual() {
		$result = $this->db->where(array('estatus'=>1,'tipo'=>1))->get('Evaluaciones');
		if($result->num_rows() != 1)
			$result = $this->db->where(array('estatus'=>2,'tipo'=>1))->get('Evaluaciones');
		return $result->first_row()->id;

	}
}