<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Masiva_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function dropTables($tipo) {
		switch ($tipo) {
			case 1:
				if($this->db->truncate('Porcentajes_Objetivos'))
					if($this->db->truncate('Metricas'))
						if($this->db->truncate('Objetivos_Areas'))
							if($this->db->truncate('Objetivos'))
								if($this->db->truncate('Areas'))
									if($this->db->truncate('Dominios'))
										return true;
				break;
			case 2:
				if($this->db->truncate('Comportamiento_Posicion'))
					if($this->db->truncate('Comportamientos'))
						if($this->db->truncate('Competencias'))
							if($this->db->truncate('Indicadores'))
								return true;
				break;
		}
		return false;
	}

	function registraCompetencias($rows,$head) {
		foreach ($rows as $key => $val) :
			foreach ($val as $row => $value) :
				switch ($row) {
					case 'A':
						$result=$this->db->select('id')->where('nombre',$value)->get('Indicadores');
						if($result->num_rows() == 1)
							$indicador=$result->first_row()->id;
						else{
							$this->db->insert('Indicadores',array('nombre'=>$value));
							if($this->db->affected_rows() == 1)
								$indicador=$this->db->insert_id();
							else
								return false;
						}
						break;
					case 'C':
						$result=$this->db->select('id')->where('nombre',$value)->get('Competencias');
						if($result->num_rows() == 1)
							$competencia=$result->first_row()->id;
						else{
							$this->db->insert('Competencias',array('nombre'=>$value,'indicador'=>$indicador));
							if($this->db->affected_rows() == 1)
								$competencia=$this->db->insert_id();
							else
								return false;
						}
						break;
					case 'D':
						$result=$this->db->select('descripcion')->where('id',$competencia)->get('Competencias')->first_row()->descripcion;
						if(!$result){
							$this->db->where('id',$competencia)->update('Competencias',array('descripcion'=>$value));
							if($this->db->affected_rows() != 1)
								return false;
						}
						break;
					case 'E':
						$comportamiento=explode('.', $value);
						$this->db->insert('Comportamientos',array('descripcion'=>$comportamiento[1],
							'valor'=>$comportamiento[0],'competencia'=>$competencia));
						if($this->db->affected_rows() == 1)
							$comportamiento=$this->db->insert_id();
						break;
					case 'G':
					case 'H':
					case 'I':
					case 'J':
					case 'K':
					case 'L':
						if($value == 'ü'){
							$this->db->insert('Comportamiento_Posicion',array('posicion'=>$head[$row],
								'comportamiento'=>$comportamiento));
						}
						break;
					default:
						# code...
						break;
				}
			endforeach;
		endforeach;
		return true;
	}

	function registraObjetivos($rows,$head) {
		$k=1;
		foreach ($rows as $key => $val) {
			if(count($val) >= 30)
				foreach ($val as $row => $value) :
					if($row == "A" && $row=="")
						break;
					switch ($row) {
						case 'A':
							$result=$this->db->select('id')->where('nombre',$value)->get('Dominios');
							if($result->num_rows() == 1)
								$dominio=$result->first_row()->id;
							else{
								$this->db->insert('Dominios',array('nombre'=>$value));
								if($this->db->affected_rows() == 1)
									$dominio=$this->db->insert_id();
								else
									return false;
							}
							break;
						case 'B':
							$this->db->insert('Objetivos',array('nombre'=>$value,'dominio'=>$dominio));
							if($this->db->affected_rows() == 1)
								$objetivo=$this->db->insert_id();
							else
								return false;
							break;
						case 'C':
							$this->db->where('id',$objetivo)
								->update('Objetivos',array('descripcion'=>$value));
							if($this->db->affected_rows() != 1)
								return false;
							break;
						case 'D':
							$metricas=explode("\n",$value);
							$j=0;
							for ($i=5; $i > 0; $i--) :
								$metrica=substr($metricas[$j++], 2);
								$this->db->insert('Metricas',array('valor'=>$i,'descripcion'=>$metrica,
									'objetivo'=>$objetivo));
								if($this->db->affected_rows() != 1)
									return false;
							endfor;
							break;
						case 'X':
						case 'Y':
						case 'Z':
						case 'AA':
						case 'AB':
						case 'AC':
							$valor=$value*100;
							$this->db->insert('Porcentajes_Objetivos',array('objetivo'=>$objetivo,'valor'=>$valor,
								'posicion'=>$head[$row]));
							if($this->db->affected_rows() != 1)
								exit();
							break;
						case 'AD':
							break;
						default:
							$result=$this->db->select('id')->where('nombre',$head[$row])->get('Areas');
							if($result->num_rows() == 1){
								$area=$result->first_row()->id;
								if($value=='SÍ'){
									$this->db->insert('Objetivos_Areas',array('objetivo'=>$objetivo,'area'=>$area));
									if($this->db->affected_rows() != 1)
										return false;
								}
							}
							break;
					}
				endforeach;
		}
		return true;
	}

	function registraAreas($areas) {
		$this->db->where('estatus',1)->or_where('estatus',0)->delete('Areas');
		foreach ($areas as $key => $value) {
			switch ($key) {
				case 'A':
				case 'B':
				case 'C':
				case 'D':
				case 'X':
				case 'Y':
				case 'Z':
				case 'AA':
				case 'AB':
				case 'AC':
				case 'AD':
					break;
				default:
					if($this->db->select('id')->where('nombre',$value)->get('Areas')->num_rows() < 1)
						$this->db->insert('Areas',array('nombre'=>$value));
					else
						return false;
					break;
			}
		}
		return true;
	}
}