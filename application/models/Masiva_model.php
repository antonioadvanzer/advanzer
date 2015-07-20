<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Masiva_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function dropTables() {
		if($this->db->truncate('Porcentajes_Objetivos'))
			if($this->db->truncate('Metricas'))
				if($this->db->truncate('Objetivos_Areas'))
					if($this->db->truncate('Objetivos'))
						if($this->db->truncate('Areas'))
							if($this->db->truncate('Dominios'))
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
								return false;
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