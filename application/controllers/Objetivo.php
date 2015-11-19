<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Objetivo extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
        $this->valida_sesion();
    	$this->load->model('objetivo_model');
    	$this->load->model('metrica_model');
    	$this->load->model('dominio_model');
    	$this->load->model('area_model');
        $this->load->model('porcentaje_objetivo_model');
    }

    function ver($id,$msg=null) {
        $this->valida_acceso();
    	$data=array();
    	if (!empty($msg))
    		$data['err_msg'] = $msg;
    	$data['objetivo'] = $this->objetivo_model->searchById($id);
    	$data['dominios'] = $this->dominio_model->getAll();
        $data['areas_asignadas'] = $this->area_model->getByObjetivo($data['objetivo']->id);
        $data['areas_no_asignadas'] = $this->area_model->getNotObjetivo($data['areas_asignadas']);
    	$this->layout->title('Capital Humano - Info Objetivo');
    	$this->layout->view('objetivo/detalle',$data);
    }

    function update() {
        $this->valida_acceso();
        $id = $this->input->post('id');
        $datos = array(
            'nombre' => $this->input->post('nombre'),
            'dominio' => $this->input->post('dominio'),
            'descripcion' => $this->input->post('descripcion'),
            'tipo' => $this->input->post('tipo')
        );
        $descripciones=$this->input->post('descripciones');
        $this->db->trans_begin();
        $this->objetivo_model->update($id,$datos);
        for ($i=0; $i < 5; $i++) :
            $this->metrica_model->update(5-$i,$id,$descripciones[$i]);
        endfor;
        $agregar = $this->input->post('agregar');
        if(!empty($agregar))
            foreach ($agregar as $area) :
                $this->objetivo_model->add_area($id,$area);
            endforeach;
        $quitar = $this->input->post('quitar');
        if(!empty($quitar))
            foreach ($quitar as $area) :
                $this->objetivo_model->del_area($id,$area);
            endforeach;
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response['msg'] = 'Error al actualizar datos del objetivo. Intenta de nuevo';
        }
        else{
            $this->db->trans_commit();
            $response['msg'] = 'ok';
        }
        echo json_encode($response);
    }

    function ch_estatus($id) {
        $this->valida_acceso();
        if($this->objetivo_model->ch_estatus($id))
            redirect('administrar_dominios');
        else{
            echo "<script>alert('Error al cambiar estatus de la resposabilidad. Intenta de nuevo');</script>";
            redirect('objetivo/ver/$id');
        }
    }

    function nuevo($msg=null) {
        $this->valida_acceso();
        if ($msg != null)
            $data['err_msg'] = $msg;
        $data['dominios'] = $this->dominio_model->getAll();
        $data['areas'] = $this->area_model->getAll();
        $this->layout->title('Advanzer - Nuevo Objetivo');
        $this->layout->view('objetivo/nuevo',$data);
    }

    function create() {
        $datos=array(
            'nombre'=>$this->input->post('nombre'),
            'dominio'=>$this->input->post('dominio'),
            'descripcion'=>$this->input->post('descripcion'),
            'tipo'=>$this->input->post('tipo')
        );
        $this->db->trans_begin();
        if($id = $this->objetivo_model->create($datos)){
            $this->metrica_model->update(5,$id,$this->input->post('cinco'));
            $this->metrica_model->update(4,$id,$this->input->post('cuatro'));
            $this->metrica_model->update(3,$id,$this->input->post('tres'));
            $this->metrica_model->update(2,$id,$this->input->post('dos'));
            $this->metrica_model->update(1,$id,$this->input->post('uno'));
            $agregar = $this->input->post('agregar');
            if(!empty($agregar))
                foreach ($agregar as $area) :
                    $this->objetivo_model->add_area($id,$area);
                endforeach;
        }
        else
            $response['msg'] = "Error al agregar objetivo. Intenta de nuevo";
        if($this->db->trans_status() === FALSE)
            $this->db->trans_rollback();
        else{
            $this->db->trans_commit();
            $response['msg'] = "ok";
        }
        echo json_encode($response);
    }

    function update_metrica() {
        $objetivo = $this->input->post('objetivo');
        $metrica = $this->input->post('valor');
        $descripcion = $this->input->post('descripcion');
        if($this->metrica_model->update($metrica,$objetivo,$descripcion))
            redirect("objetivo/ver/$objetivo");
        else
            $this->ver($objetivo,"Error al actualizar métrica. Intenta de nuevo");
    }

    function update_peso() {
        $objetivo = $this->input->post('objetivo');
        $posicion = $this->input->post('posicion');
        $valor = $this->input->post('valor');
        if($this->objetivo_model->update_peso($objetivo,$posicion,$valor))
            redirect("objetivo/ver/$objetivo");
        else
            $this->ver($objetivo,"Error al actualizar Peso Relativo. Intenta de nuevo");
    }

    function asignar_pesos() {
        $data=array();
        $direccion = $this->session->userdata('direccion');
        if($this->session->userdata('tipo') >= 4)
            $direccion=null;
        $data['areas'] = $this->porcentaje_objetivo_model->getPorcentajes($direccion);;
        $this->layout->title('Capital Humano - Pesos Específicos');
        $this->layout->view('objetivo/asignar_pesos',$data);
    }

    function asigna_peso() {
        $objetivo_area = $this->porcentaje_objetivo_model->getObjetivoArea(array('objetivo'=>$this->input->post('responsabilidad'),
            'area'=>$this->input->post('area')));
        $datos=array(
            'nivel_posicion'=>$this->input->post('posicion'),
            'objetivo_area'=>$objetivo_area
        );
        $valor = $this->input->post('valor');
        if($this->porcentaje_objetivo_model->asigna_peso($datos,$valor))
            $response['msg']="ok";
        else
            $response['msg']="Error, intenta de nuevo";
        echo json_encode($response);
    }

    private function valida_sesion() {
        if($this->session->userdata('id') == "")
            redirect('login');
    }

    private function valida_acceso() {
        if($this->session->userdata('tipo') < 4)
        redirect();
    }
}