<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';
 
    public function estructura() {
       $this->layout->title('Capital Humano - Estructura Organizacional');
       $data = array();
       $this->layout->view('info/estructura', $data);     // Render view and layout
    }

    public function cartas_constancias() {
    	$this->layout->title('Capital Humano - Cartas/Constancias Laborales');
    	$data=array();
    	$this->layout->view('info/cartas_constancias', $data);
    }

    public function certificacion_sap() {
    	$this->layout->title('Capital Humano - Certificación SAP');
    	$data=array();
    	$this->layout->view('info/certificacion_sap', $data);
    }

    public function viaticos_gastos() {
    	$this->layout->title('Capital Humano - Viáticos y Gastos de Viaje');
    	$data=array();
    	$this->layout->view('info/viaticos_gastos', $data);
    }

    public function vacaciones() {
    	$this->layout->title('Capital Humano - Vacaciones');
    	$data=array();
    	$this->layout->view('info/vacaciones', $data);
    }

    public function permisos() {
    	$this->layout->title('Capital Humano - Permisos');
    	$data=array();
    	$this->layout->view('info/permisos', $data);
    }

    public function vestimenta() {
    	$this->layout->title('Capital Humano - Código de Vestimenta');
    	$data=array();
    	$this->layout->view('info/vestimenta', $data);
    }
}