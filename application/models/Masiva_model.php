<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Masiva_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function dropTables($tipo) {
		$this->db->query('set foreign_key_checks=0');
		switch ($tipo) {
			case 1:
				if($this->db->truncate('Porcentajes_Objetivos'))
					if($this->db->truncate('Metricas'))
						if($this->db->truncate('Objetivos_Areas'))
							if($this->db->truncate('Objetivos'))
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
		$this->db->query('set foreign_key_checks=1');
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
						}
						break;
					case 'B':
						$result=$this->db->select('id')->where('nombre',$value)->get('Competencias');
						if($result->num_rows() == 1)
							$competencia=$result->first_row()->id;
						else{
							$this->db->insert('Competencias',array('nombre'=>$value,'indicador'=>$indicador));
							if($this->db->affected_rows() == 1)
								$competencia=$this->db->insert_id();
						}
						break;
					case 'C':
						$result=$this->db->select('descripcion')->where('id',$competencia)->get('Competencias')->first_row()->descripcion;
						if(!$result)
							$this->db->where('id',$competencia)->update('Competencias',array('descripcion'=>$value));
						break;
					case 'D':
						$comportamiento=explode('.', $value);
						$this->db->insert('Comportamientos',array('descripcion'=>trim($comportamiento[1]),
							'competencia'=>$competencia));
						if($this->db->affected_rows() == 1)
							$comportamiento=$this->db->insert_id();
						break;
					case 'E':
					case 'F':
					case 'G':
					case 'H':
					case 'I':
					case 'J':
						if($value == 'ü')
							$this->db->insert('Comportamiento_Posicion',array('nivel_posicion'=>$head[$row],
								'comportamiento'=>$comportamiento));
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
				$oas=array();
				foreach ($val as $row => $value) :
					switch ($row) {
						case 'A':
							$tipo=$value;
							break;
						case 'B':
							$result=$this->db->select('id')->where('nombre',$value)->get('Dominios');
							if($result->num_rows() == 1)
								$dominio=$result->first_row()->id;
							else{
								$this->db->insert('Dominios',array('nombre'=>$value));
								if($this->db->affected_rows() == 1)
									$dominio=$this->db->insert_id();
							}
							break;
						case 'C':
							$res=$this->db->select('id')->where('nombre',$value)->get('Objetivos');
							if($res->num_rows() == 1)
								$objetivo=$res->first_row()->id;
							else{
								$this->db->insert('Objetivos',array('nombre'=>$value,'dominio'=>$dominio,'tipo'=>$tipo));
								if($this->db->affected_rows() == 1)
									$objetivo=$this->db->insert_id();
							}
							break;
						case 'D':
							$this->db->where('id',$objetivo)->update('Objetivos',array('descripcion'=>$value));
							break;
						case 'E':
							$res=$this->db->select('id')->where('objetivo',$objetivo)->get('Metricas');
							if($res->num_rows() == 0){
								$metricas=explode("\n",$value);
								$j=0;
								for ($i=5; $i > 0; $i--) :
									$metrica=substr($metricas[$j++], 2);
									$this->db->insert('Metricas',array('valor'=>$i,'descripcion'=>$metrica,'objetivo'=>$objetivo));
									if($this->db->affected_rows() != 1)
										return false;
								endfor;
							}
							break;
						case 'Y':
						case 'Z':
						case 'AA':
						case 'AB':
						case 'AC':
						case 'AD':
							foreach ($oas as $objetivo_area):
								$valor=$value*100;
								$this->db->insert('Porcentajes_Objetivos',array('objetivo_area'=>$objetivo_area,'valor'=>$valor,'nivel_posicion'=>$head[$row]));
								if($this->db->affected_rows() != 1)
									exit();
							endforeach;
							break;
						default:
							if($value=='SI'){
								$flag=false;
								$res=$this->db->where('objetivo',$objetivo)->get('Objetivos_Areas')->result();
								foreach ($res as $r) :
									if($r->area == $head[$row]){
										$objetivo_area=$r->id;
										$flag=true;
									}
								endforeach;
								if($flag==false){
									$this->db->insert('Objetivos_Areas',array('objetivo'=>$objetivo,'area'=>$head[$row]));
									$objetivo_area=$this->db->insert_id();
								}
								array_push($oas, $objetivo_area);
							}
							break;
					}
				endforeach;
		}
		return true;
	}
}