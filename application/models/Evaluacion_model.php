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

	function getResponsabilidadByArea($area,$posicion) {
		$this->db->distinct();
		$this->db->select('D.id, D.nombre,D.descripcion');
		$this->db->from('Areas A');
		$this->db->join('Objetivos_Areas OA','OA.area = A.id');
		$this->db->join('Porcentajes_Objetivos PO','PO.objetivo_area = OA.id');
		$this->db->join('Objetivos O','O.id = OA.objetivo');
		$this->db->join('Dominios D','O.dominio = D.id');
		$this->db->order_by('D.nombre');
		$this->db->where(array('A.id'=>$area,'D.estatus'=>1,'A.estatus'=>1,'O.estatus'=>1,'PO.nivel_posicion'=>$posicion));
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

	function getEvaluadores() {
		$this->db->distinct();
		$this->db->select('Us.id,Us.foto,Us.nombre')->from('Users Us');
		$this->db->join('Evaluadores Ev','Us.id = Ev.evaluador');
		$this->db->join('Evaluaciones E','E.id = Ev.evaluacion');
		$this->db->where(array('E.inicio <='=>date('Y-m-d'),'E.fin >='=>date('Y-m-d')));
		$this->db->where('Ev.evaluado != Ev.evaluador');
		$this->db->order_by('Us.nombre');
		$result = $this->db->get()->result();
		foreach ($result as $evaluador) :
			$evaluador->asignaciones = null;
			$evaluador->asignaciones360 = null;
			$evaluador->asignacionesProyecto = null;
			//evaluaciones
			$this->db->select('Ev.id,Ev.evaluado,Us.nombre,Us.foto')->from('Evaluadores Ev');
			$this->db->join('Evaluaciones E','E.id = Ev.evaluacion');
			$this->db->join('Users Us','Us.id = Ev.evaluado');
			$this->db->where(array('E.inicio <='=>date('Y-m-d'),'E.fin >='=>date('Y-m-d'),'Ev.evaluado !='=>$evaluador->id,
				'Ev.evaluador'=>$evaluador->id,'E.tipo'=>1));
			$this->db->where("(Us.jefe=$evaluador->id OR E.lider=$evaluador->id)");
			$asignaciones = $this->db->get()->result();
			foreach ($asignaciones as $asignacion) :
				$res = $this->db->select('total')->where('asignacion',$asignacion->id)->get('Resultados_ev_Competencia');
				($res->num_rows() == 1) ? $asignacion->competencia = $res->first_row()->total : $asignacion->competencia=null;
				$res = $this->db->select('total')->where('asignacion',$asignacion->id)->get('Resultados_ev_Responsabilidad');
				($res->num_rows() == 1) ? $asignacion->responsabilidad = $res->first_row()->total : $asignacion->responsabilidad=null;
				$asignacion->total = ($asignacion->competencia*0.3)+($asignacion->responsabilidad*0.7);
			endforeach;
			$evaluador->asignaciones = $asignaciones;

			//evaluaciones 360
			$this->db->select('Ev.id,Ev.evaluado,Us.nombre,Us.foto')->from('Evaluadores Ev');
			$this->db->join('Evaluaciones E','E.id = Ev.evaluacion');
			$this->db->join('Users Us','Us.id = Ev.evaluado');
			$this->db->join('Posicion_Track PT','PT.id = Us.posicion_track');
			$this->db->join('Posiciones P','P.id = PT.posicion');
			$this->db->where(array('E.inicio <='=>date('Y-m-d'),'E.tipo'=>1,'E.fin >='=>date('Y-m-d'),'Ev.evaluado !='=>$evaluador->id));
			$this->db->where(array('Us.jefe!='=>$evaluador->id,'P.nivel >='=>3,'P.nivel <='=>5,'Ev.evaluador'=>$evaluador->id,'E.tipo'=>1));
			$asignaciones = $this->db->get()->result();
			foreach ($asignaciones as $asignacion) :
				$res = $this->db->select('total')->where('asignacion',$asignacion->id)->get('Resultados_ev_Competencia');
				($res->num_rows() == 1) ? $asignacion->total = $res->first_row()->total : $asignacion->total=null;
			endforeach;
			$evaluador->asignaciones360 = $asignaciones;

			//evaluaciones de proyecto
			$this->db->select('Ev.id,Ev.evaluado,Us.nombre,Us.foto')->from('Evaluadores Ev');
			$this->db->join('Evaluaciones E','E.id = Ev.evaluacion');
			$this->db->join('Users Us','Us.id = Ev.evaluado');
			$this->db->where(array('E.inicio <='=>date('Y-m-d'),'E.fin >='=>date('Y-m-d'),'Ev.evaluado !='=>$evaluador->id,
				'Ev.evaluador'=>$evaluador->id,'E.tipo'=>0));
			$this->db->where("(Us.jefe=$evaluador->id OR E.lider=$evaluador->id)");
			$asignaciones = $this->db->get()->result();
			foreach ($asignaciones as $asignacion) :
				$res = $this->db->select('total')->where('asignacion',$asignacion->id)->get('Resultados_ev_Competencia');
				($res->num_rows() == 1) ? $asignacion->competencia = $res->first_row()->total : $asignacion->competencia=null;
				$res = $this->db->select('total')->where('asignacion',$asignacion->id)->get('Resultados_ev_Responsabilidad');
				($res->num_rows() == 1) ? $asignacion->responsabilidad = $res->first_row()->total : $asignacion->responsabilidad=null;
				$asignacion->total = ($asignacion->competencia*0.3)+($asignacion->responsabilidad*0.7);
			endforeach;
			$evaluador->asignacionesProyecto = $asignaciones;
		endforeach;
		return $result;
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
		$this->db->select('U.id,U.foto,U.nombre,U.nomina,A.nombre area,P.nombre posicion,Ev.nombre evaluacion,E.estatus,E.id asignacion,
			Ev.inicio,Ev.fin,Ev.tipo');
		$this->db->from('Users U');
		$this->db->join('Areas A','A.id = U.area','LEFT OUTER');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		$this->db->join('Evaluadores E','E.evaluado = U.id','LEFT OUTER');
		$this->db->join('Evaluaciones Ev','Ev.id = E.evaluacion','LEFT OUTER');
		$this->db->where(array('E.evaluador'=>$evaluador,'U.estatus'=>1));
		$this->db->order_by('E.estatus,Ev.nombre,U.nombre');
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
			$colaborador->cumple_gastos = $res->first_row()->cumple_gastos;
			$colaborador->cumple_harvest = $res->first_row()->cumple_harvest;
			$colaborador->cumple_cv = $res->first_row()->cumple_cv;
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
			$this->db->select('U.id,U.foto,U.nombre,E.id asignacion,E.comentarios')->from('Users U');
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
		$this->db->select('U.id,U.foto,U.nombre,E.id asignacion,E.comentarios');
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

		//evaluaciones por proyecto
		if($proyectos=$this->getEvaluacionesProyecto()):
			$ids = array();
			foreach ($proyectos as $row)
				array_push($ids, $row->id);
			$this->db->select('U.id,U.foto,U.nombre,E.id asignacion,Ev.nombre evaluacion,E.comentarios')->from('Users U')
				->join('Evaluadores E','E.evaluador = U.id')
				->join('Evaluaciones Ev','Ev.id = E.evaluacion','LEFT OUTER')
				->where_in('Ev.id',$ids)->where(array('Ev.estatus !='=>0,'E.evaluado'=>$colaborador->id,'E.evaluador !='=>$colaborador->id))
				->order_by('Ev.nombre,U.nombre');
			$colaborador->evaluadoresProyecto = $this->db->get()->result();
			foreach ($colaborador->evaluadoresProyecto as $evaluador) :
				$res=$this->db->from('Resultados_ev_Responsabilidad')->where('asignacion',$evaluador->asignacion)->get();
				($res->num_rows() == 1) ? $evaluador->responsabilidad = $res->first_row()->total : $evaluador->responsabilidad = null;
				//$asignacion = $evaluador->asignacion;
			endforeach;
		endif;

		return $colaborador;
	}

	function calculaResultado($asignacion) {
		$posicion=$this->getPosicionByColaborador($asignacion->evaluado);
		$jefe=$this->db->select('jefe')->from('Users')->where('id',$asignacion->evaluado)->get()->first_row()->jefe;
		$competencia=0;
		$responsabilidad=0;
		//si es de gerente a director se evalúa 360
		if($posicion >= 3 && $posicion <= 5){
			$this->db->select('AVG(RC.total) total360')->from('Resultados_ev_Competencia RC')
				->join('Evaluadores Ev','Ev.id = RC.asignacion')
				->where(array('Ev.evaluado'=>$asignacion->evaluado,'Ev.evaluacion'=>$asignacion->evaluacion,'Ev.evaluador !='=>$jefe,
				'Ev.evaluador !='=>$asignacion->evaluado));
			$res = $this->db->get();
			if($res->num_rows() == 1)
				(double)$competencia += (double)($res->first_row()->total360)*0.1;
		}
		//evaluacion del jefe directo / líderes de proyecto (encargado de evaluar anualmente)
		$this->db->select('RC.total')->from('Resultados_ev_Competencia RC')
			->join('Evaluadores Ev','Ev.id = RC.asignacion')
			->where(array('Ev.evaluado'=>$asignacion->evaluado,'Ev.evaluacion'=>$asignacion->evaluacion,'Ev.evaluador'=>$jefe));
		$res=$this->db->get();
		if($res->num_rows() == 1)
			if($posicion >= 3 && $posicion <= 5)
				(double)$competencia += (double)($res->first_row()->total)*0.1;
			else
				(double)$competencia += (double)($res->first_row()->total)*0.15;
		//autoevaluación
		$this->db->select('RC.total')->from('Resultados_ev_Competencia RC')
			->join('Evaluadores Ev','Ev.id = RC.asignacion')
			->where(array('Ev.evaluado'=>$asignacion->evaluado,'Ev.evaluacion'=>$asignacion->evaluacion,'Ev.evaluador'=>$asignacion->evaluado));
		$res=$this->db->get();
		if($res->num_rows() == 1)
			if($posicion >= 3 && $posicion <= 5)
				(double)$competencia += ($res->first_row()->total)*0.1;
			else
				(double)$competencia += ($res->first_row()->total)*0.15;
		//evaluaciones de proyectos
		$proyectos=$this->getEvaluacionesProyecto();
		$ids = array();
		foreach ($proyectos as $row)
			array_push($ids, $row->id);
		$this->db->select('RR.total,E.fin_periodo,E.inicio_periodo')->from('Resultados_ev_Responsabilidad RR')
			->join('Evaluadores Ev','Ev.id = RR.asignacion')
			->join('Evaluaciones E','E.id = Ev.evaluacion')
			->where('Ev.evaluado',$asignacion->evaluado)->where_in('Ev.evaluacion',$ids);
		$res=$this->db->get();
		if($res->num_rows() > 0):
			$r_proyectos=0;
			$dias_total=0;
			foreach ($res->result() as $info) :
				$diferencia=date_diff(date_create($info->inicio_periodo),date_create($info->fin_periodo));
				$dias=(int)$diferencia->format("%a");
				$dias_total+=$dias;
			endforeach;
			foreach ($res->result() as $info) :
				$r_proyectos += $info->total*($dias/$dias_total);
			endforeach;
		endif;
		//evaluacion jefe
		$this->db->select('AVG(RR.total) total')->from('Resultados_ev_Responsabilidad RR');
		$this->db->join('Evaluadores Ev','Ev.id = RR.asignacion');
		$this->db->join('Evaluaciones E','E.id = Ev.evaluacion');
		$this->db->where(array('Ev.evaluado'=>$asignacion->evaluado,'E.tipo'=>1));
		$res=$this->db->get();
		if($res->num_rows() == 1)
			(double)$r_anual = ($res->first_row()->total);
		(isset($r_proyectos)) ? (double)$responsabilidad = (($r_anual + $r_proyectos)/2)*.7 : (double)$responsabilidad = $r_anual;

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
		$this->db->select('U.id,U.foto,U.nombre,A.nombre area')
			->join('Areas A','A.id = U.area')
			->where('U.fecha_ingreso <=','2015-10-31')
			->group_by('U.id')
			->order_by('U.nombre');
		$result = $this->db->get('Users U')->result();
		$evaluacion=$this->getEvaluacionAnual();
		foreach ($result as $user) :
			$user->total_evaluadores = $this->db->select('count(evaluador) total')
			->where(array('evaluador !='=>$user->id,'evaluado'=>$user->id,'evaluacion'=>$evaluacion))->get('Evaluadores')->first_row()->total;
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
		$this->db->select('Ev.evaluador id,Us.nombre,P.nombre posicion,T.nombre track,Ev.estatus');
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
			foreach ($result->dominios=$this->getResponsabilidadByArea($area,$posicion) as $dominio) :
				foreach ($dominio->responsabilidades=$this->getObjetivosByDominio($dominio->id,$area,$posicion) as $responsabilidad) :
					$responsabilidad->respuesta = $this->getRespuestaByAsignacionResponsabilidad($asignacion,$responsabilidad->id);
					$responsabilidad->metricas = $this->getMetricaByObjetivo($responsabilidad->id);
				endforeach;
			endforeach;
		}
		return $result;
	}

	function getProyectoByAsignacion($asignacion) {
		$result = $this->searchAsignacionById($asignacion);
		$posicion=$this->getPosicionByColaborador($result->evaluado);
		$area = $this->getAreaByColaborador($result->evaluado);
		foreach ($result->dominios=$this->getResponsabilidadByArea($area,$posicion) as $dominio) :
			$res = $this->db->from('Detalle_ev_Proyecto')->where(array('asignacion'=>$asignacion,'dominio'=>$dominio->id))->get();
			if($res->num_rows() == 1):
				$res = $res->first_row();
				$dominio->respuesta = $res->respuesta;
				$dominio->justificacion = $res->justificacion;
			else:
				$dominio->respuesta = null;
				$dominio->justificacion = null;
			endif;
		endforeach;
		return $result;
	}

	function guardaMetrica($asignacion,$metrica,$objetivo) {
		$id_m=$this->db->select('id')->where(array('objetivo'=>$objetivo,'valor'=>$metrica))->get('Metricas')->first_row()->id;
		$result = $this->db->from('Detalle_Evaluacion')->where(array('objetivo'=>$objetivo,'asignacion'=>$asignacion))->get();
		if($result->num_rows() == 1){
			$id_detalle=$result->first_row()->id;
			$this->db->where('id',$id_detalle)->update('Detalle_Evaluacion',array('metrica'=>$id_m));
		}else
			$this->db->insert('Detalle_Evaluacion',array('asignacion'=>$asignacion,'objetivo'=>$objetivo,'metrica'=>$id_m));
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

	function guardaDominio($asignacion,$respuesta,$dominio,$justificacion) {
		$result = $this->db->from('Detalle_ev_Proyecto')->where(array('dominio'=>$dominio,'asignacion'=>$asignacion))->get();
		if($result->num_rows() == 1){
			$id_detalle=$result->first_row()->id;
			$this->db->where('id',$id_detalle)->update('Detalle_ev_Proyecto',array('respuesta'=>$respuesta,'justificacion'=>$justificacion));
		}else
			$this->db->insert('Detalle_ev_Proyecto',array('asignacion'=>$asignacion,'respuesta'=>$respuesta,'dominio'=>$dominio,
				'justificacion'=>$justificacion));
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

	function guardaComportamiento($asignacion,$respuesta,$comportamiento) {
		$result = $this->db->from('Detalle_ev_Competencia')->where(array('asignacion'=>$asignacion,'comportamiento'=>$comportamiento))->get();
		if($result->num_rows() == 1){
			$id_detalle=$result->first_row()->id;
			$this->db->where('id',$id_detalle)->update('Detalle_ev_Competencia',array('respuesta'=>$respuesta));
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
		return $this->db->select('E.comentarios,E.id,Ev.tipo,E.evaluador,E.evaluado,E.estatus,Ev.id evaluacion,Ev.nombre')->from('Evaluadores E')
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

	function finalizar_evaluacion($asignacion,$tipo,$comentarios) {
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
				$this->calculaResultado($info);
				break;
			case 0:
				$total = $this->db->select('AVG(respuesta) total')->where('asignacion',$asignacion)->get('Detalle_ev_Proyecto')
					->first_row()->total;
				$this->db->insert('Resultados_ev_Responsabilidad',array('asignacion'=>$asignacion,'total'=>$total));
				break;
		}
		$this->db->where('id',$info->id)->update('Evaluadores',array('comentarios'=>$comentarios));
		if($this->ch_estatus($asignacion,2))
			return true;
		return false;
	}

	function autogenera($colaboradores,$evaluacion) {
		foreach ($colaboradores as $colaborador) :
			$diferencia=date_diff(date_create($colaborador->fecha_ingreso),date_create('2015-10-31'));
			if($diferencia->format('%R') == '+'):
				$jefe=$this->db->select('jefe')->from('Users')->where('id',$colaborador->id)->get()->first_row()->jefe;
				if($colaborador->id != $jefe)
					$this->evaluacion_model->addEvaluadorToColaborador(array('evaluador'=>$jefe,
                    	'evaluado'=>$colaborador->id,'evaluacion'=>$evaluacion));
			endif;
		endforeach;
	}

	function create($datos) {
		$this->db->insert('Evaluaciones',$datos);
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		else
			return false;
	}

	function getEvaluacionAnual() {
		$result = $this->db->where_in('estatus',array(1,2))->where(array('tipo'=>1,'inicio <='=>date('Y-m-d'),'fin >='=>date('Y-m-d')))
			->get('Evaluaciones');
		if($result->num_rows() != 0)
			return $result->first_row()->id;
		return false;
	}

	function getEvaluacionesProyecto() {
		$result = $this->db->where_in('estatus',array(1,2))->where(array('tipo'=>0,'anio'=>date('Y')))
			->get('Evaluaciones');
		if($result->num_rows() != 0):
			return $result->result();
		endif;
		return false;
	}
}