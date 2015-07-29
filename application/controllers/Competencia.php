<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Competencia extends CI_Controller {
	// Layout used in this controller
	public $layout_view = 'layout/default';

	function __construct(){
		parent::__construct();
		$this->load->model('competencia_model');
		$this->load->model('indicador_model');
	}

	function nuevo($msg=null,$err=null) {
		$data=array();
		if($msg!=null)
			$data['msg']=$msg;
		if($err!=null)
			$data['err_msg']=$err;
		$data['indicadores'] = $this->indicador_model->getAll();
		$this->layout->title('Advanzer - Registro Competencia');
		$this->layout->view('competencia/nuevo',$data);
	}

	function create() {
		$nombre=$this->input->post('nombre');
		$indicador=$this->input->post('indicador');
		$descripcion=$this->input->post('descripcion');
		$puntuacion=$this->input->post('puntuacion');
		$competencia=$this->competencia_model->create($nombre,$indicador,$descripcion,$puntuacion);
		if($competencia)
			$this->ver($competencia);
		else
			$this->nuevo(null,"Error al agregar nueva competencia. Intenta de nuevo");
	}

	function ver($id,$msg=null,$err=null) {
		if($err!=null)
			$data['err_msg']=$err;
		if($msg!=null)
			$data['msg']=$msg;
		$data['indicadores']=$this->indicador_model->getAll();
		$data['competencia']=$this->competencia_model->searchById($id);
		$this->layout->title('Advanzer - Detalle Competencia');
		$this->layout->view('competencia/detalle',$data);
	}

	function add_comportamiento() {
		$competencia = $this->input->post('competencia');
		$descripcion=$this->input->post('comportamiento');
		$posiciones=$this->input->post('selected');

		$this->db->trans_begin();
		
		$comportamiento=$this->competencia_model->addComportamiento($competencia,$descripcion);
		if($comportamiento):
			foreach ($posiciones as $posicion) :
				$this->competencia_model->addPosicionToComportamiento($comportamiento,$posicion);
			endforeach;
		endif;

		if($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}

	function del_comportamientos() {
		$comportamientos=$this->input->post('selected');

		$this->db->trans_begin();

		foreach ($comportamientos as $comportamiento) :
			$this->competencia_model->delComportamiento($comportamiento);
		endforeach;
		if($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}

	function update() {
		$id=$this->input->post('id');
		$nombre=$this->input->post('nombre');
		$descripcion=$this->input->post('descripcion');
		$puntuacion=$this->input->post('puntuacion');
		$indicador=$this->input->post('indicador');
		if($this->competencia_model->update($id,$nombre,$descripcion,$puntuacion,$indicador))
			$this->ver($id,"Se ha actualizado la competencia");
		else
			$this->ver($id,null,"Error al actualizar la competencia. Intente de nuevo");
	}
}