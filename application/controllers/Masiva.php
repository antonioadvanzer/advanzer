<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masiva extends CI_Controller {
	// Layout used in this controller
	public $layout_view = 'layout/default';

	function __construct(){
		parent::__construct();
		$this->load->model('masiva_model');
	}

	function carga_comp_resp () {
		$data=array();
		$this->layout->title('Advanzer - Carga Masiva');
		$this->layout->view('masiva/carga_comp_resp',$data);
	}

	function upload_comp_resp() {
		$tipo=$this->input->post('tipo');
		$status="";$msg="";$file_name='file';

		$config['upload_path'] = './assets/docs/';
		$config['allowed_types'] = 'xls|xlsx';
		$config['file_name'] = $tipo.'_Carga_Masiva_'.date('Y-m-d');
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($file_name)){
			$status = 'error';
			$msg = $this->upload->display_errors('','');
		}else{
			$status="success";
			$msg="Carga Masiva Completa";
			$data = $this->upload->data();
			$this->load->library('excel');
			$objPHPExcel = PHPExcel_IOFactory::load($data['full_path']);

			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				//header will/should be in row 1 only. of course this can be modified to suit your need.
				if ($row == 1)
					$header[$row][$column] = $data_value;
				else
					$arr_data[$row][$column] = $data_value;
			}

			$this->db->trans_begin();
			//vaciar tablas
			if(!$this->masiva_model->dropTables($tipo))
				exit();
			//llenar tablas en base al tipo(1=responsabilidades, 2=competencias)
			switch ($tipo) {
				case 1:
					foreach ($header as $h => $valores) :
						if(!$this->masiva_model->registraAreas($valores))
							exit();
						$head=$valores;
					endforeach;
					
					if(!$this->masiva_model->registraObjetivos($arr_data,$head))
						exit();
					break;
				case 2:
					foreach ($header as $h => $valores) {
						$head=$valores;
					}
					if(!$this->masiva_model->registraCompetencias($arr_data,$head))
						exit();
					break;

				default:
					# code...
					break;
			}
			
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				unlink($data['full_path']);
				$status = "error";
				$msg = "Ha habido un error con el archivo. Revisalo e intenta de nuevo";
			}
			else{
				$this->db->trans_commit();
				$status="success";
				$msg="Carga Masiva Completa";
			}

			@unlink($_FILES[$file_name]);
		}
		echo json_encode(array('status'=>$status,'msg'=>$msg));
	}

	//Funciones extras
	function get_cell($cell, $objPHPExcel){
		//select one cell
		$objCell = ($objPHPExcel->getActiveSheet()->getCell($cell));
		//get cell value
		return $objCell->getvalue();
	}
		function pp(&$var){
		$var = chr(ord($var)+1);
		return true;
	}
}