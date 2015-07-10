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

<<<<<<< HEAD
	function getByText($valor,$tipo) {
		$this->db->select('Us.foto,Ev.id id,Us.nombre nombre,count(Ev.evaluado) as cantidad');
		$this->db->join('Users as Us','Us.id = Ev.evaluador');
		$this->db->where('Ev.estatus',0);
		$this->db->where('Ev.tipo',$tipo);
=======
	function getByText($valor) {
		$this->db->select('Us.foto,Ev.id id,Us.nombre nombre,count(Ev.evaluado) as cantidad');
		$this->db->join('Users as Us','Us.id = Ev.evaluador');
		$this->db->where('Ev.estatus',0);
		$this->db->where('Ev.360',0);
>>>>>>> 01ed01f4ec342ba3dbe36292789a3beb593a2028
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

<<<<<<< HEAD
	function getNotByEvaluador($evaluador,$ignore,$tipo) {
=======
	function getNotByEvaluador($evaluador,$ignore) {
>>>>>>> 01ed01f4ec342ba3dbe36292789a3beb593a2028
		if(count($ignore)>0){
			$array_temp=array();
			foreach ($ignore as $temp) 
				array_push($array_temp, $temp->id);
			$this->db->where_not_in('Us.id',$array_temp);
		}
<<<<<<< HEAD
		if($tipo == 1){
			$this->db->where_in('Us.posicion',array('Gerente / Master','Gerente Sr / Experto','Director'));
		}
=======
>>>>>>> 01ed01f4ec342ba3dbe36292789a3beb593a2028
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
<<<<<<< HEAD
}
=======
}
>>>>>>> 01ed01f4ec342ba3dbe36292789a3beb593a2028
