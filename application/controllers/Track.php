<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Track extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
        $this->load->model('track_model');
        $this->load->model('posicion_model');
    }
 
    public function index($msg=null) {
    	$data = array();
    	if (!empty($msg))
    		$data['msg'] = $msg;
    	$data['tracks'] = $this->track_model->getAll();
    	$this->layout->title('Advanzer - Tracks y Posiciones');
    	$this->layout->view('track/index',$data);
    }

    public function load_posiciones() {
        $track=$this->input->post('track');
            foreach ($this->posicion_model->getByTrack($track) as $posicion) : ?>
                <tr>
                    <td><small><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
                        location.href='<?= base_url('posicion/ver');?>/'+<?= $posicion->id;?>"></span>
                        <span style="cursor:pointer" onclick="location.href='<?= base_url('posicion/ver');?>/'+
                            <?= $posicion->id;?>"><?= $posicion->nombre;?></span></small></td>
                </tr>
            <?php endforeach;
    }

    public function nuevo($err=null) {
        $data=array();
        if($err!=null)
            $data['err_msg'] = $err;
        $this->layout->title('Advanzer - Registro Track');
        $this->layout->view('track/nuevo',$data);
    }

    public function create() {
        $nombre=$this->input->post('nombre');
        if($this->track_model->create($nombre))
            $response['msg'] = "ok";
        else
            $response['msg'] = "Error al registrar nuevo track. Intenta de nuevo";
        echo json_encode($response);
    }

    public function ver($id,$err=null) {
        if($err!=null)
            $data['err_msg']=$err;
        $data['track']=$this->track_model->getById($id);
        $this->layout->title('Advanzer - Detalle Track');
        $this->layout->view('track/detalle',$data);
    }

    public function update() {
        $id=$this->input->post('id');
        $nombre=$this->input->post('nombre');
        if($this->track_model->update($id,$nombre))
            $response['msg'] = "ok";
        else
            $response['msg'] = "Error al actualizar track. Intenta de nuevo";
        echo json_encode($response);
    }
}