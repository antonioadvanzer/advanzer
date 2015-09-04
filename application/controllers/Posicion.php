<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posicion extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
        $this->load->model('posicion_model');
        $this->load->model('track_model');
    }

    public function nuevo($err=null) {
    	if($err!=null)
    		$data['err_msg'] = $err;
    	$data['tracks']=$this->track_model->getAll();
    	$this->layout->title('Advanzer - Registro Posicion');
    	$this->layout->view('posicion/nuevo',$data);
    }

    public function create() {
    	$nombre=$this->input->post('nombre');
    	$tracks=$this->input->post('tracks');
    	$this->db->trans_begin();
    	if($posicion=$this->posicion_model->create($nombre)){
    		foreach ($tracks as $track) :
    			$this->posicion_model->addTrackToPosicion($track,$posicion);
    		endforeach;
    	}
    	if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$this->nuevo("Error al agregar posición. Intenta de nuevo");
		}
		else{
			$this->db->trans_commit();
			redirect('track');
		}
    }

    public function ver($id,$err=null) {
        if($err != null)
            $data['err_msg'] = $err;
        $data['posicion']=$this->posicion_model->getById($id);
        $data['tracks_no_agregados']=$this->track_model->getNotByPosicion($id);
        $this->layout->title('Advanzer - Detalle Posición');
        $this->layout->view('posicion/detalle',$data);
    }

    public function add_tracks() {
        $posicion = $this->uri->segment(3,null);
        if ($posicion) {
            $tracks=$this->input->post('selected');
            foreach ($tracks as $track) {
                if(!$this->posicion_model->addTrack($posicion,$track))
                    break;
            }
        }
    }

    public function del_tracks() {
        $posicion = $this->uri->segment(3,null);
        if ($posicion) {
            $tracks=$this->input->post('selected');
            foreach ($tracks as $track) {
                if(!$this->posicion_model->delTrack($posicion,$track))
                    break;
            }
        }
    }

    public function update() {
        $id=$this->input->post('id');
        $datos = array('nombre'=>$this->input->post('nombre'));
        if($this->posicion_model->update($id,$datos)){
            $response['msg'] = "ok";
            $response['alert'] = "Actualización realizada";
        }else
            $response['msg'] = "Error al actualizar el nombre de la posición";
        echo json_encode($response);
    }
}