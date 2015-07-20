<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Evaluacion_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function getEvaluadores($tipo=0) {
		$this->db->select('Us.foto,Ev.id id,Us.nombre nombre,count(Ev.evaluado) as cantidad');
		$this->db->join('Users as Us','Us.id = Ev.evaluador');
		$this->db->where('Ev.estatus',0);
		$this->db->where('Ev.tipo',$tipo);
		$this->db->group_by('Ev.evaluador');
		$this->db->order_by('Us.nombre','asc');
		return $this->db->get('Evaluadores as Ev');
	}

	function getByText($valor,$tipo) {
		$this->db->select('Us.foto,Ev.id id,Us.nombre nombre,count(Ev.evaluado) as cantidad');
		$this->db->join('Users as Us','Us.id = Ev.evaluador');
		$this->db->where('Ev.estatus',0);
		$this->db->where('Ev.tipo',$tipo);

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
		$this->db->where('Ev.tipo',$tipo);
		$this->db->group_by('Ev.evaluador');
		$this->db->order_by('Us.nombre','asc');
		return $this->db->get('Evaluadores as Ev')->result();
	}

	function getByEvaluador($evaluador,$tipo=0) {
		$this->db->select('Us.id,Us.nombre,Us.posicion');
		$this->db->where('evaluador',$evaluador);
		$this->db->where('Ev.tipo',$tipo);
		$this->db->from('Evaluadores Ev');
		$this->db->join('Users Us','Ev.evaluado = Us.id');
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
			$this->db->where_in('Us.posicion',array('Gerente / Master','Gerente Sr / Experto','Director'));

		$this->db->where('Us.id !=',$evaluador);
		$this->db->select('Us.id,Us.nombre,Us.posicion');
		$this->db->from('Users Us');
		return $this->db->get()->result();
	}

	function addColaboradorToEvaluador($evaluador,$colaborador,$tipo) {
		$this->db->insert('Evaluadores',array('evaluador'=>$evaluador,'evaluado'=>$colaborador,'tipo'=>$tipo));
		if($this->db->insert_id())
			return true;
		else
			return false;
	}

	function delColaboradorFromEvaluador($evaluador,$colaborador,$tipo) {
		$this->db->where(array('evaluador'=>$evaluador,'evaluado'=>$colaborador,'tipo'=>$tipo));
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