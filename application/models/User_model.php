<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class User_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}


	function solicitudesByColaborador($colaborador,$flag=null) {
		$this->db->select('S.*,U.nombre')->from('Solicitudes S')->join('Users U','U.id = S.autorizador','LEFT OUTER')->where("(S.colaborador = $colaborador)")->order_by('S.fecha_solicitud','desc');		
		$result = $this->db->get()->result();
		foreach ($result as $solicitud) 
			if($solicitud->tipo == 4)
				$solicitud->detalle = $this->db->where('solicitud',$solicitud->id)->get('Detalle_Viaticos')->first_row();
		return $result;
	}
	
	function countSolicitudesByColaborador($colaborador) {
		
		$this->db->select('*')->from('Solicitudes')->where("(colaborador = $colaborador) and (estatus=3 or estatus=4) and (alerta=1)")->order_by('fecha_solicitud','desc');
		$result = $this->db->get()->result();
		
		return count($result);
	}

	function solicitudes_pendientes($colaborador){
		
		/*if($this->session->userdata('area') == 4){
			$this->db->where("((S.tipo != 4 and S.estatus=2) or (S.autorizador=$colaborador and S.estatus=1)) or (S.estatus=3 and desde='".date('Y-m-d')."')");
		}elseif($this->session->userdata('area')==9){
			$this->db->join('Detalle_Viaticos DV','DV.solicitud=S.id','LEFT OUTER')->where("(S.estatus=3 and S.tipo=4 and anticipo = 0) or (S.autorizador=$colaborador and S.estatus=1) or (S.tipo=5 and S.estatus=1)");
		}else{
			$this->db->where('S.autorizador',$colaborador);
		}*/
		    
		$this->db->where("(S.autorizador=$colaborador) and ((S.estatus=1) or ((S.estatus=4) and (S.not_jefe=1)))");
		
		$this->db->select('S.*,U.nombre')->from('Solicitudes S')
			->join('Users U','U.id = S.colaborador');
		
		$result = $this->db->get()->result();
		
		foreach ($result as $solicitud) {
			if($solicitud->tipo == 4)
				$solicitud->detalle = $this->db->where('solicitud',$solicitud->id)->get('Detalle_Viaticos')->first_row();
			if($solicitud->tipo == 1)
				$solicitud->historial=$this->db->where("id != $solicitud->id and tipo=1 and (estatus=3 or (estatus !=3 and DATEDIFF(fecha_ultima_modificacion,CURDATE())<7))")->get('Solicitudes')->result();
			if($solicitud->tipo == 5)
				$solicitud->comprobantes = $this->db->where(array('solicitud'=>$solicitud->id,'estatus'=>1))->get('Comprobantes')->result();
		}
		return $result;
	}	
	
	function countSolicitudesPendientesAutorizar($colaborador){
		
		$this->db->select('*')->from('Solicitudes')->where("(autorizador = $colaborador) and (((estatus=1) and (alerta=1)) or ((estatus=4) and (not_jefe=1)))");
		$result = $this->db->get()->result();
		
		return count($result);
	}

	// Extraer todos las solitudes qe ya esten autorizadas por el jefe directo y que solo sea caso diferente
	function solicitudes_autorizar_ch(){
		
		$this->db->select('S.*,U.nombre')->from('Solicitudes S')->where("S.estatus=2 or (S.estatus= 4 and S.not_ch=1)")
		->join('Users U','U.id = S.colaborador');
		
		$result = $this->db->get()->result();
		
		return $result;
	}
	
	// Contar aquellos que ya se autorizaron
	function countSolicitudesAutorizarCh(){
		
		$this->db->where("((estatus=2) and (alerta=1)) or ((estatus=4) and (not_ch=1))");
		
		$this->db->select('*')->from('Solicitudes');
		
		$result = $this->db->get()->result();
		
		return count($result);
	}

	// Permitir recuperar solicitudes por tipo y estado
	function getSolicitudes($estado, $tipo){
		
		$this->db->select('Sv.*,U.nombre')
			->from('Solicitudes Sv')
			->join('Users U','U.id = Sv.colaborador');

		if(($estado == 0) || ($estado == 1) || ($estado == 2) || ($estado == 3) || ($estado == 4)){
			$this->db->where('Sv.estatus', $estado);
		}
		
		if($tipo == 1){
			$this->db->where('Sv.tipo', 1);
		}elseif($tipo == 2){
			$this->db->where('(Sv.tipo=2) or (Sv.tipo=3)');
		}
		
		$result = $this->db->get()->result();
		
		foreach ($result as $solicitud) :
			if($solicitud->autorizador)
				$solicitud->autorizador=$this->db->where('id',$solicitud->autorizador)->get('Users')->first_row()->nombre;
			else
				$solicitud->autorizador='ÁREA DE FINANZAS';
		endforeach;
		
		return $result;
	}
	
	function getSolicitudesVacaciones($colaborador){
				
		$this->db->select('S.*,U.nombre')
				->from('Solicitudes S')
				->join('Users U','U.id = S.autorizador','LEFT OUTER')
				->where("(S.colaborador = $colaborador)")
				->where('S.tipo', 1)
				->order_by('S.fecha_solicitud','desc');		
		
		$result = $this->db->get()->result();
		
		return $result;
	}
	
	function getSolicitudesPermisosAusencia($colaborador){
		
		$this->db->select('S.*,U.nombre')
			->from('Solicitudes S')
			->join('Users U','U.id = S.autorizador','LEFT OUTER')
			->where("(S.colaborador = $colaborador)")
			->where('(S.tipo=2) or (S.tipo=3)')
			->order_by('S.fecha_solicitud','desc');		
		
		$result = $this->db->get()->result();
				
		return $result;
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

	function getPagination($flag) {
		$this->db->select('U.id,U.nomina,U.categoria,U.plaza,U.nombre,U.email,U.foto,U.empresa,U.estatus,A.nombre area,
			T.nombre track,P.nombre posicion,U.fecha_ingreso');
		$this->db->join('Areas A','U.area = A.id','LEFT OUTER');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
		$this->db->join('Tracks T','PT.track = T.id','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->order_by('nombre');
		if($flag)
			$this->db->where('U.estatus',0);
		else
			$this->db->where('U.estatus',1);
		return $this->db->get('Users U')->result();
	}

	function getJefes($id) {
		return $this->db->where(array('id !='=>$id,'estatus'=>1))->order_by('nombre')->get('Users')->result();
	}

	function searchById($id) {
		$this->db->select('U.*,A.nombre nombre_area,P.id posicion,T.id track,P.nivel nivel_posicion,T.nombre nombre_track,P.nombre nombre_posicion');
		$this->db->join('Posicion_Track PT','PT.id = U.posicion_track','LEFT OUTER');
		$this->db->join('Posiciones P','P.id = PT.posicion','LEFT OUTER');
		$this->db->join('Tracks T','T.id = PT.track','LEFT OUTER');
		$this->db->join('Areas A','A.id = U.area','LEFT OUTER');
		$this->db->where('U.id',$id);
		$result = $this->db->get('Users U')->first_row();
		$res = $this->db->select('nombre')->where('id',$result->jefe)->get('Users');
		(($res->num_rows()) > 0) ? $result->nombre_jefe = $res->first_row()->nombre :$result->nombre_jefe="";
		$result->historial = $this->getHistorialById($result->id);
		$result->bitacora = $this->solicitudesByColaborador($result->id,true);
		$result->vacaciones=$this->db->where('colaborador',$result->id)->get('Vacaciones')->first_row();
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

	function actualiza_vacaciones($id,$datos) {
		$result=$this->db->where('colaborador',$id)->get('Vacaciones');
		if($result->num_rows()==1)
			$this->db->where('id',$result->first_row()->id)->update('Vacaciones',$datos);
		else{
			$array['colaborador']=$id;
			$this->db->insert('Vacaciones',$array);
		}
		if($this->db->affected_rows() == 1)
			return TRUE;
		else
			return FALSE;
	}

	function change_historial($where,$datos) {
		$this->db->where($where)->update('Historial',$datos);
		if($this->db->affected_rows() == 1)
			return true;
		return false;
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

	function cleanUser($id) {
		$this->db->where('jefe',$id)->update('Users',array('jefe'=>null));
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

	function getDirectores() {
		$this->db->select('U.id,U.nombre')
			->join('Posicion_Track PT','PT.id = U.posicion_track')
			->join('Posiciones P','P.id = PT.posicion')
			->join('Tracks T','T.id = PT.track');
			$this->db->where('P.nivel <=',3);
		return $this->db->where('U.estatus',1)->order_by('nombre','asc')->get('Users U')->result();
	}

	function getHistorialById($id) {
		$result = $this->db->where('colaborador',$id)->get('Historial')->result();
		foreach ($result as $anio) :
			$anio->flag=1;
			if($anio->anio >= 2015):
				$res = $this->db->where(array('E.anio'=>$anio->anio,'RE.colaborador'=>$id,'F.estatus'=>2))->from('Feedbacks F')
					->join('Resultados_Evaluacion RE','RE.id=F.resultado')->join('Evaluaciones E','E.id = RE.evaluacion')->get();
				if($res->num_rows() == 0)
					$anio->flag=0;
			endif;
		endforeach;
		if(isset($result))
		return $result;
	}

	function getHistorialByIdAnio($id,$anio) {
		return $this->db->where(array('colaborador'=>$id,'anio'=>$anio))->get('Historial')->first_row();
	}
	
	// Get access type for diferents areas
	function getPermisos($area){
		
		/*SELECT p.access, p.nombre AS CapitalHumano
		FROM `Permisos_Area` AS pa
		INNER JOIN Permisos AS p ON pa.permiso = p.id
		WHERE pa.area =4*/
		
		// Busqueda de permisos por area
		return $this->db->where(array('pa.area'=>$area))->from('Permisos_Area pa')
					->join('Permisos p','pa.permiso=p.id')->get()->result();
	}

	// Get access type for diferents areas
	function getAllPermisos(){
		
		// pendiente
		return $this->db->from('Permisos ')->get()->result();
	}

	function logout($id,$email) {
		$descripcion = "cerró sesión: $email";
		$this->db->insert('Bitacora',array('accion'=>5,'descripcion'=>$descripcion,'valor'=>$id));
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

}