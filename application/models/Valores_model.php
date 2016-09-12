<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Valores_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function create_actividades_mes($user, $valor) {
		$this->db->insert('Actividad_Mes',['usuario' => $user, 'valor' => $valor, 'a1' => 0, 'a2' => 0, 'a3' => 0]);
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

	function update_actividades_mes($user, $valor, $pieza) {
		$this->db->where('usuario',$user)->where('valor', $valor)->update('Actividad_Mes',[$pieza => 1]);
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

	// recuperar los registros de actividades realizadas
	function getRelationActividades($user) {
		$this->db->select('AM.*, V.*');
		$this->db->join('Valor V','AM.valor = V.id','LEFT OUTER');
		$this->db->where('AM.usuario',$user);
        $this->db->where('V.active', 1);
		//$this->db->order_by('mes');
		
		return $this->db->get('Actividad_Mes AM')->result();
	}

}