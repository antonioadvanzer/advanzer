<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class User_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function do_login($email,$password=null){
		$this->db->select('U.id,U.email,U.nombre,U.foto,U.empresa,U.tipo,P.nivel nivel_posicion,A.id area,T.nombre track,A.direccion')
			->from('Users U')->join('Areas A','A.id = U.area','LEFT OUTER')
			->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER')
			->join('Posiciones P','P.id = PT.posicion','LEFT OUTER')
			->join('Tracks T','T.id = PT.track','LEFT OUTER')
			->where('U.email',$email)
			->where('U.estatus',1);
		if($password != null)
			$this->db->where('U.password',md5($password));
		$this->db->limit(1);

		$query=$this->db->get();
		if ($query->num_rows() == 1){
			$descripcion = 'ingreso al sistema de: '.$query->first_row()->email;
			$this->db->insert('Bitacora',array('accion'=>5,'descripcion'=>$descripcion,'valor'=>$query->first_row()->id));
			return $query->first_row();
		}
		return false;
	}

	function getCountUsers($valor=null,$estatus=null) {
		if($estatus!=null) {
			if($estatus < 2){
				$ids=array('');
				$this->db->where('estatus',$estatus);
				$result=$this->db->select('id')->get('Users')->result();
				foreach ($result as $row) {
					array_push($ids, $row->id);
				}
				if(count($ids)>0)
					$this->db->where_in('U.id',$ids);
			}
		}
			$this->db->select('U.id,U.nomina,U.categoria,U.plaza,U.nombre,U.email,U.foto,U.empresa,U.estatus, 
				A.nombre area,T.nombre track,P.nombre posicion');
			$this->db->join('Areas A','U.area = A.id','LEFT OUTER');
			$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
			$this->db->join('Tracks T','PT.track = T.id','LEFT OUTER');
			$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		if($valor!=null)
			$this->db->where("(U.nombre like '%$valor%' || U.email like '%$valor%' || P.nombre like '%$valor%' ||
				T.nombre like '%$valor%' || U.nomina like '%$valor%' || U.nombre like '%$valor%')");
		return $this->db->count_all_results('Users U');
	}

	function getPagination() {
		$this->db->select('U.id,U.nomina,U.categoria,U.plaza,U.nombre,U.email,U.foto,U.empresa,U.estatus,A.nombre area,
			T.nombre track,P.nombre posicion');
		$this->db->join('Areas A','U.area = A.id','LEFT OUTER');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
		$this->db->join('Tracks T','PT.track = T.id','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->order_by('nombre');
		return $this->db->get('Users U')->result();
	}

	function getJefes($id) {
		return $this->db->where(array('id !='=>$id,'estatus'=>1))->order_by('nombre')->get('Users')->result();
	}

	function searchById($id) {
		$this->db->select('U.id,U.email,U.nombre,U.foto,U.empresa,U.estatus,U.categoria,U.nomina,U.area,U.plaza,A.nombre nombre_area,U.tipo,U.jefe,
			U.fecha_ingreso,P.id posicion, T.id track,P.nivel nivel_posicion,T.nombre nombre_track,P.nombre nombre_posicion,U.fecha_ingreso');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		$this->db->join('Areas A','A.id = U.area','LEFT OUTER');
		$this->db->where('U.id',$id);
		$result = $this->db->get('Users U')->first_row();
		$res = $this->db->select('nombre')->where('id',$result->jefe)->get('Users');
		(($res->num_rows()) > 0) ? $result->nombre_jefe = $res->first_row()->nombre :$result->nombre_jefe="";
		return $result;
	}

	function getTrackByUser($user) {
		$this->db->select('T.id');
		$this->db->from('Tracks T');
		$this->db->join('Posicion_Track PT','PT.track = T.id');
		$this->db->join('Users U','U.posicion_track = PT.id');
		$this->db->where('U.id',$user);
		$result = $this->db->get();
		if($result->num_rows() > 0)
			return $result->first_row()->id;
	}

	function update_foto($id,$nombre) {
		$this->db->where('id',$id);
		$this->db->update('Users',array('foto'=>$nombre));
	}

	function update($id,$datos) {
		$this->db->where('id',$id);
		$this->db->update('Users',$datos);
		if($this->db->affected_rows() == 1)
			return TRUE;
		else
			return FALSE;
	}

	function create($datos) {
		$this->db->insert('Users',$datos);
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		return false;
	}

	function getStatus($id) {
		$this->db->select('estatus');
		$this->db->where('id',$id);
		return $this->db->get('Users')->first_row()->estatus;
	}

	function enable_disable($id,$datos) {
		$this->db->where('id',$id);
		$this->db->update('Users',$datos);
		if ($this->db->affected_rows() == 1)
			return true;
		else
			return false;
	}

	function getByText($valor="",$estatus=1,$orden='DESC') {
		if($estatus < 2){$ids=array('');
			$this->db->where('estatus',$estatus);
			$result=$this->db->select('id')->get('Users')->result();
			foreach ($result as $row) {
				array_push($ids, $row->id);
			}
			if(count($ids)>0)
				$this->db->where_in('U.id',$ids);
		}
		$this->db->select('U.id,U.nomina,U.categoria,U.plaza,U.nombre,U.email,U.foto,U.empresa,U.estatus,
			A.nombre area,T.nombre track,P.nombre posicion');
		$this->db->join('Areas A','U.area = A.id','LEFT OUTER');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
		$this->db->join('Tracks T','PT.track = T.id','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		if(!empty($valor))
			$this->db->where("(U.nombre like '%$valor%' || U.email like '%$valor%' || P.nombre like '%$valor%' ||
				T.nombre like '%$valor%' || U.nomina like '%$valor%' || U.nombre like '%$valor%')");
		/*$this->db->like('U.nombre',$valor,'both');
		$this->db->or_like('U.email',$valor,'both');
		$this->db->or_like('P.nombre',$valor,'both');
		$this->db->or_like('T.nombre',$valor,'both');
		$this->db->or_like('U.nomina',$valor,'both');*/
		$this->db->order_by('U.nombre',$orden);
		if($estatus < 2)
			$this->db->where('U.estatus',$estatus);
		return $this->db->get('Users U')->result();
	}
	function getAll($tipo=null) {
		if($tipo == 1)
			$this->db->where('P.nivel <=',5);
		$this->db->select('U.id,U.nombre,U.email,U.foto,U.empresa,U.categoria,U.nomina,U.fecha_ingreso,
			U.area,U.plaza,P.nombre posicion,T.nombre track,P.nivel nivel_posicion');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track');
		$this->db->join('Posiciones P','P.id = PT.posicion');
		$this->db->join('Tracks T','T.id = PT.track');
		return $this->db->where('U.estatus',1)->order_by('nombre','asc')->get('Users U')->result();
	}
}