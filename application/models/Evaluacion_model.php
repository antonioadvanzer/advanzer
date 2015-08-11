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
		return $this->db->get()->result();
	}

	function getObjetivosByDominio($dominio,$area,$posicion) {
		$this->db->select('O.id,O.nombre,PO.valor,O.descripcion');
		$this->db->from('Objetivos O');
		$this->db->join('Objetivos_Areas OA','OA.objetivo = O.id');
		$this->db->join('Porcentajes_Objetivos PO','PO.objetivo = O.id');
		$this->db->where(array('O.dominio'=>$dominio,'OA.area'=>$area,'PO.nivel_posicion'=>$posicion,'O.estatus'=>1));
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

	function getPagination($limit, $start,$tipo=0) {
		$this->db->limit($limit,$start);
		$this->db->select('Us.foto,Ev.evaluador id,Us.nombre nombre,count(Ev.evaluado) as cantidad');
		$this->db->join('Users as Us','Us.id = Ev.evaluador');
		$this->db->where('Ev.estatus',0);
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
		$this->db->join('Posicion_Track PT','PT.id = Us.posicion_track');
		$this->db->join('Posiciones P','P.id = PT.posicion');
		$this->db->join('Tracks T','T.id = PT.track');
		return $this->db->get()->result();
	}

	function getNotByEvaluador($evaluador,$ignore,$tipo=0) {
		if(count($ignore)>0){
			$array_temp=array();
			foreach ($ignore as $temp) 
				array_push($array_temp, $temp->id);
			$this->db->where_not_in('Us.id',$array_temp);
		}
		if($tipo == 1)
			$this->db->where('P.nivel <=',5);

		$this->db->select('Us.id,Us.nombre,P.nombre posicion,T.nombre track');
		$this->db->where('Us.id !=',$evaluador);
		$this->db->from('Users Us');
		$this->db->join('Posicion_Track PT','PT.id = Us.posicion_track');
		$this->db->join('Posiciones P','P.id = PT.posicion');
		$this->db->join('Tracks T','T.id = PT.track');
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
		$this->db->where('estatus',0);
		$this->db->order_by('nombre','desc');
		return $this->db->get('Evaluaciones')->result();
	}

	function gestionar($evaluacion,$inicio,$fin,$tipo) {
		$this->db->where('id',$evaluacion);
		$this->db->update('Evaluaciones',array('inicio'=>$inicio,'fin'=>$fin,'tipo'=>$tipo));
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function getEvaluacionById($id) {
		$this->db->where('id',$id);
		return $this->db->get('Evaluaciones')->first_row();
	}

	function create($nombre,$descripcion,$inicio,$fin) {
		$datos=array('nombre'=>$nombre,'descripcion'=>$descripcion);
		if($inicio!="")
			$datos['inicio']=$inicio;
		if($fin!="")
			$datos['fin']=$fin;
		$this->db->insert('Evaluaciones',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}
}