<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluacion extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
        $this->valida_sesion();
    	$this->load->model('evaluacion_model');
        $this->load->model('area_model');
        $this->load->model('user_model');
    	$this->load->library('pagination');
    }

    public function evaluar() {
        $evaluador=$this->session->userdata('id');
        $data['colaboradores']=$this->evaluacion_model->getEvaluacionesByEvaluador($evaluador);
        $this->layout->title('Advanzer - Evaluaciones');
        $this->layout->view('evaluacion/evaluar',$data);
    }

    public function aplicar($asignacion) {
        $this->genera_evaluacion($asignacion);
        $data['evaluacion']=$this->evaluacion_model->getEvaluacionByAsignacion($asignacion);
        $this->layout->title('Advanzer - Aplicar Evaluación');
        $this->layout->view('evaluacion/aplicar',$data);
    }

    public function guardar_avance() {
        $asignacion = $this->input->post('asignacion');
        $tipo = $this->input->post('tipo');
        $valor = $this->input->post('valor');
        $elemento = $this->input->post('elemento');
        if($tipo=="responsabilidad"){
            if($this->evaluacion_model->guardaMetrica($asignacion,$valor,$elemento)) //metrica=valor,obj=elem
                $data['msg'] = "Métrica Guardada";
        }else{
            if($this->evaluacion_model->guardaComportamiento($asignacion,$valor,$elemento)) //resp=valor,comp=elem
                $data['msg'] = "Comportamiento Guardado";
        }
        if($this->evaluacion_model->is_filled_evaluacion($asignacion,$tipo))
            $data['terminada']="si";
        else
            $data['terminada']="no";
        echo json_encode($data);
    }

    public function finalizar_evaluacion() {
        $asignacion = $this->input->post('asignacion');
        if($this->evaluacion_model->finalizar_evaluacion($asignacion)){
            $data['msg'] = "Evaluación Finalizada.";
            $data['redirecciona']="si";
        }else{
            $data['msg'] = "Error al finalizar la evaluación. Verifica tus respuestas e intenta de nuevo";
            $data['redirecciona']="no";
        }
        echo json_encode($data);
    }

    public function index() {
        $data=array();

        //pagination settings
        $config['base_url'] = base_url('evaluacion');
        $config['total_rows'] = $this->evaluacion_model->getCountUsers();
        $config['per_page'] = "8";
        $config["uri_segment"] = 2;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        //call the model function to get the data
        $data['colaboradores'] = $this->evaluacion_model->getEvaluados($config["per_page"], $data['page']);
        
        $data['pagination'] = $this->pagination->create_links();

        $this->layout->title('Advanzer - Evaluaciones');
        $this->layout->view('evaluacion/index',$data);
    }

    public function load_competencias() {
        $posicion = $this->input->post('posicion');
        foreach ($this->evaluacion_model->getIndicadoresByPosicion($posicion) as $indicador) : ?>
            <h1><?= $indicador->nombre;?></h1>
            <div> <?php 
                foreach ($this->evaluacion_model->getCompetenciasByIndicador($indicador->id,$posicion) as $comp) : ?>
                    <h2><?= $comp->nombre;?></h2>
                    <div align="left">
                        <label><?= $comp->descripcion;?></label>
                        <p><ul type="square"> <?php
                            foreach ($this->evaluacion_model->getComportamientoByCompetencia($comp->id,$posicion) as $comportamiento) : ?>
                                    <span class="glyphicon glyphicon-ok-circle"><?= $comportamiento->descripcion;?></span>
                            <?php endforeach; ?>
                        </ul></p>
                    </div> <?php
                endforeach; ?>
            </div> <?php
        endforeach;
    }

    public function load_perfil() {
        $area = $this->input->post('area');
        $posicion = $this->input->post('posicion');
        foreach ($this->evaluacion_model->getResponsabilidadByArea($area) as $dominio) :?>
            <h1><?= $dominio->nombre;?></h1>
            <div>
            <?php foreach ($this->evaluacion_model->getObjetivosByDominio($dominio->id,$area,$posicion) as $responsabilidad): ?>
                <h2><?= $responsabilidad->nombre;?><span style="float:right;"><?= $responsabilidad->valor;?>%</span></h2>
                <div align="left">
                    <label><?= $responsabilidad->descripcion;?></label>
                    <p><ol reversed>
                        <?php foreach ($this->evaluacion_model->getMetricaByObjetivo($responsabilidad->id) as $metrica) :?>
                            <li><?= $metrica->descripcion;?></li>
                        <?php endforeach; ?>
                    </ol></p>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endforeach;
    }

    public function perfil() {
        $data=array();
        $area = $this->session->userdata('area');
        $posicion = $this->session->userdata('posicion');
        if(!empty($area) && !empty($posicion)){
            //get perfil de evaluación de responsabilidades
            $data['dominios'] = $this->evaluacion_model->getResponsabilidadByArea($area);
            foreach ($data['dominios'] as $dominio) :
                $dominio->responsabilidades = $this->evaluacion_model->getObjetivosByDominio($dominio->id,$area,$posicion);
                foreach ($dominio->responsabilidades as $responsabilidad) :
                    $responsabilidad->metricas = $this->evaluacion_model->getMetricaByObjetivo($responsabilidad->id);
                endforeach;
            endforeach;
            //get perfil de evaluacion de competencias
            $data['indicadores'] = $this->evaluacion_model->getIndicadoresByPosicion($posicion);
            foreach ($data['indicadores'] as $indicador) :
                $indicador->competencias = $this->evaluacion_model->getCompetenciasByIndicador($indicador->id,$posicion);
                foreach ($indicador->competencias as $competencia) : 
                    $competencia->comportamientos = $this->evaluacion_model->getComportamientoByCompetencia($competencia->id,$posicion);
                endforeach;
            endforeach;
        }
        $data['areas']=$this->area_model->getAll(1);
        $data['area_usuario'] = $area;
        $this->layout->title('Advanzer - Perfil de Evaluación');
        $this->layout->view('evaluacion/perfil',$data);
    }

    public function evaluaciones($msg=null) {
        $data['colaboradores'] = $this->evaluacion_model->getPagination();
    	
        $this->layout->title('Advanzer - Evaluaciones');
    	$this->layout->view('evaluacion/evaluaciones',$data);
    }

    public function asignar_evaluador($colaborador){
        $data['colaborador']=$this->user_model->searchById($colaborador);
        $data['evaluadores']=$this->evaluacion_model->getEvaluadoresByColaborador($colaborador);
        $data['no_evaluadores']=$this->evaluacion_model->getNotEvaluadoresByColaborador($colaborador,$data['evaluadores']);

        $this->layout->title('Capital Humano - Asignar Evaluadores');
        $this->layout->view('evaluacion/asignar_evaluador',$data);
    }

    public function guarda_evaluadores() {
        $colaborador=$this->input->post('colaborador');
        $agregar=$this->input->post('agregar');
        $this->input->post('evaluacion') ? $evaluacion=$this->input->post('evaluacion') : $evaluacion=$this->evaluacion_model->getEvaluacionAnual();
        $this->db->trans_begin();
        if(!empty($agregar))
            foreach ($agregar as $evaluador) :
                $this->evaluacion_model->addEvaluadorToColaborador(
                    array('evaluador'=>$evaluador,'evaluado'=>$colaborador,'evaluacion'=>$evaluacion));
            endforeach;
        $quitar=$this->input->post('quitar');
        if(!empty($quitar))
            foreach ($quitar as $evaluador) :
                $this->evaluacion_model->delEvaluadorFromColaborador(
                    array('evaluador'=>$evaluador,'evaluado'=>$colaborador,'evaluacion'=>$evaluacion));
            endforeach;
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response['msg'] = "Ha habido un error. Intenta de nuevo";
        }
        else{
            $this->db->trans_commit();
            $response['msg']="ok";
        }
        echo json_encode($response);
    }

    public function proyecto() {
        $data['evaluaciones'] = $this->evaluacion_model->getEvaluacionesSinAplicar();
        $this->layout->title('Advanzer - Gestión de Proyectos');
        $this->layout->view('evaluacion/proyecto',$data);
    }

    public function gestionar() {
        $evaluacion=$this->input->post('evaluacion');
        $datos=array(
            'inicio'=>$this->input->post('inicio'),
            'fin'=>$this->input->post('fin'),
            'estatus'=>$this->input->post('estatus')
        );
        if($this->input->post('tipo') == 0){
            $datos['lider']=$this->input->post('lider');
            $agregar = $this->input->post('agregar');
            $quitar = $this->input->post('quitar');
        }
        $this->db->trans_begin();
        $old_lider=$this->evaluacion_model->getEvaluacionById($evaluacion)->lider;
        $this->evaluacion_model->gestionar($evaluacion,$datos);
        if(!empty($datos['lider'])){
            if($old_lider != $datos['lider'])
                $this->evaluacion_model->eraseByEvaluador($evaluacion,$old_lider);
            if(!empty($agregar))
                foreach ($agregar as $colaborador) :
                    if($colaborador != $datos['lider'])
                        $this->evaluacion_model->addEvaluadorToColaborador(
                            array('evaluador'=>$datos['lider'],'evaluado'=>$colaborador,'evaluacion'=>$evaluacion));
                endforeach;
            $quitar=$this->input->post('quitar');
            if(!empty($quitar))
                foreach ($quitar as $colaborador) :
                    $this->evaluacion_model->delEvaluadorFromColaborador(
                        array('evaluador'=>$datos['lider'],'evaluado'=>$colaborador,'evaluacion'=>$evaluacion));
                endforeach;
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response['msg'] = "Ha habido un error. Intenta de nuevo";
        }
        else{
            $this->db->trans_commit();
            $response['affected']=true;
            $response['msg']="Evaluación Modificada";
        }
        echo json_encode($response);
    }

    public function load_info_evaluacion() {
        $evaluacion=$this->input->post('evaluacion');
        $info=$this->evaluacion_model->getEvaluacionById($evaluacion);
        if($info->tipo == 0){
            $lider=$this->evaluacion_model->getInfoLider($info->lider);
            $participantes=$this->evaluacion_model->getParticipantesByEvaluacion($evaluacion);
            $disponibles=$this->user_model->getAll();
        }
        if($info->estatus > 2): ?>
          <script>
            $('#submit').prop('disabled',true);
            $('#inicio').prop('disabled',true);
            $('#fin').prop('disabled',true);
            $('#estatus').prop('disabled',true);
          </script>
        <?php elseif($info->estatus == 2) : ?>
          <script>
            $('#inicio').prop('disabled',true);
            $('#estatus').prop('disabled',true);
          </script>
        <?php endif; ?>
        <script>
            $(document).ready(function() {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                if(dd<10)
                    dd='0'+dd
                if(mm<10)
                    mm='0'+mm
                today = yyyy+'-'+mm+'-'+dd;
                $('#inicio').datepicker({
                    dateFormat: 'yy-mm-dd',
                    minDate: today,
                    maxDate: '+30d'
                });
                $('#fin').datepicker({dateFormat: 'yy-mm-dd',minDate: $('#inicio').val()});
                $("#evaluacion").change(function() {
                    $("#evaluacion option:selected").each(function() {
                        evaluacion = $('#evaluacion').val();
                    });
                    $.ajax({
                        url: '<?= base_url("evaluacion/load_info_evaluacion");?>',
                        type: 'post',
                        data: {'evaluacion': evaluacion},
                        beforeSend: function(xhr) {
                            $('#update').hide();
                            $('#cargando').show();
                        },
                        success: function(data) {
                            $('#cargando').hide();
                            $('#update').show();
                            $("#datos").html(data);
                            $("#submit").show();
                        }
                    });
                });

                $('#update').submit(function(event) {
                    $('#alert').prop('display',false).hide();
                    $('#alert_success').prop('display',false).hide();
                    if(valida_fechas(this)){
                        $('#cargando').show();
                        $("#evaluacion option:selected").each(function() {
                            evaluacion = $('#evaluacion').val();
                        });
                        inicio = $("#inicio").val();
                        fin = $("#fin").val();
                        $("#estatus option:selected").each(function() {
                            estatus = $('#estatus').val();
                        });
                        tipo = $('#tipo').val();
                        if(tipo == 0){
                            $("#lider option:selected").each(function() {
                                lider = $('#lider').val();
                            });
                            var agregar = [];
                            $('#agregar option').each(function(i,select) {
                                agregar[i] = $(select).val();
                            });
                            var quitar = [];
                            $('#quitar option').each(function(i,select) {
                                quitar[i] = $(select).val();
                            });
                            $.ajax({
                                url: '<?= base_url("evaluacion/gestionar");?>',
                                type: 'post',
                                data: {'evaluacion':evaluacion,'inicio':inicio,'fin':fin,'estatus':estatus,'lider':lider,
                                    'agregar':agregar,'quitar':quitar,'tipo':tipo},
                                beforeSend: function(xhr) {
                                    $('#update').hide();
                                    $('#cargando').show();
                                },
                                success: function(data) {
                                    console.log(data);
                                    $('#cargando').hide();
                                    $('#update').show();
                                    var returnData = JSON.parse(data);
                                    console.log(returnData['msg']);
                                    if(returnData['affected']){
                                        $('#alert_success').prop('display',true).show();
                                        $('#msg_success').html(returnData['msg']);
                                        setTimeout(function() {
                                            $("#alert_success").fadeOut(1500);
                                        },3000);
                                    }else{
                                        $('#alert').prop('display',true).show();
                                        $('#msg').html(returnData['msg']);
                                        setTimeout(function() {
                                            $("#alert").fadeOut(1500);
                                        },3000);
                                    }
                                }
                            });
                        }else
                            $.ajax({
                                url: '<?= base_url("evaluacion/gestionar");?>',
                                type: 'post',
                                data: {'evaluacion':evaluacion,'inicio':inicio,'fin':fin,'estatus':estatus,'tipo':tipo},
                                beforeSend: function(xhr) {
                                    $('#update').hide();
                                    $('#cargando').show();
                                },
                                success: function(data) {
                                    $('#cargando').hide();
                                    $('#update').show();
                                    var returnData = JSON.parse(data);
                                    console.log(returnData['msg']);
                                    if(returnData['affected']){
                                        $('#alert_success').prop('display',true).show();
                                        $('#msg_success').html(returnData['msg']);
                                        setTimeout(function() {
                                            $("#alert_success").fadeOut(1500);
                                        },3000);
                                    }else{
                                        $('#alert').prop('display',true).show();
                                        $('#msg').html(returnData['msg']);
                                        setTimeout(function() {
                                            $("#alert").fadeOut(1500);
                                        },3000);
                                    }
                                }
                            });
                    }
                    event.preventDefault();
                });
            });
        </script>
        <input type="hidden" id="tipo" value="<?= $info->tipo;?>">
        <div class="col-md-4">
          <div class="form-group">
            <label for="inicio">Inicia:</label>
            <input data-provide="datepicker" data-date-format="yyyy-mm-dd" name="inicio" id="inicio" 
            onchange="setFin(this);" value="<?= $info->inicio; ?>" class="form-control" style="max-width:300px;text-align:center;">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="fin">Termina:</label>
              <input data-provide="datepicker" data-date-format="yyyy-mm-dd" name="fin" id="fin" 
                value="<?= $info->fin;?>" 
                class="form-control" style="max-width:300px;text-align:center;">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="estatus">Estatus:</label>
            <select id="estatus" name="estatus" class="form-control" style="max-width:300px;text-align:center">
              <option selected disabled>-- Estatus --</option>
              <option value="0" <?php if($info->estatus == 0) echo "selected"; ?>>Deshabilitado</option>
              <option value="1" <?php if($info->estatus == 1) echo "selected"; ?>>Habilitado</option>
            </select>
          </div>
        </div>
        <?php if($info->tipo == 0) : ?>
            <div class="col-md-12">
                <div class="form-group" align="center">
                    <label for="lider">Líder de Proyecto</label>
                    <select id="lider" name="lider" class="form-control" style="max-width:300px">
                        <option value="<?= $lider->id;?>" selected>
                            <?= "$lider->nombre - $lider->posicion ($lider->track)";?></option>
                        <?php foreach($participantes as $colaborador) : ?>
                            <option value="<?= $colaborador->id;?>">
                                <?= "$colaborador->nombre - $colaborador->posicion ($colaborador->track)";?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group" align="center">
                    <label for="participantes">Participantes</label>
                    <select id="agregar" name="agregar" multiple class="form-control" style="overflow-y:auto;
                        overflow-x:auto;min-height:200px;max-height:700px">
                        <?php foreach($participantes as $colaborador) : ?>
                            <option value="<?= $colaborador->id;?>">
                                <?= "$colaborador->nombre - $colaborador->posicion ($colaborador->track)";?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2"><div class="form-group">&nbsp;</div>
                <div class="form-group">
                    <button type="button" id="btnQuitar" style="max-width:100px" class="form-control">Quitar&raquo;</button>
                </div>
                <div class="form-group">
                    <button type="button" id="btnAgregar" style="max-width:100px" class="form-control">&laquo;Agregar</button>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group" align="center">
                    <label for="participantes">Colaboradores Disponibles</label>
                    <select id="quitar" name="quitar" multiple class="form-control" style="overflow-y:auto;
                        overflow-x:auto;min-height:200px;max-height:700px">
                        <?php foreach($disponibles as $colaborador) : ?>
                            <option value="<?= $colaborador->id;?>">
                                <?= "$colaborador->nombre - $colaborador->posicion ($colaborador->track)";?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#agregar').append($('<option>',{value:$('#lider option:selected').val()}).text($('#lider option:selected').text()));
                    $('#agregar option').each(function(i,select) {
                        $('#quitar').find("option[value='"+$(select).val()+"']").remove();
                    });
                    $('#btnAgregar').click(function() {
                        if($('#quitar :selected').length > 0){
                            $('#quitar :selected').each(function(i,select) {
                                $('#quitar').find($(select)).remove();
                                $('#agregar').append($('<option>',{value:$(select).val()}).text($(select).text()));
                                $('#lider').append($('<option>',{value:$(select).val()}).text($(select).text()));
                            });
                        }
                    });
                    $('#btnQuitar').click(function() {
                        if($('#agregar :selected').length > 0){
                            $('#agregar :selected').each(function(i,select) {
                                $('#agregar').find($(select)).remove();
                                $('#lider').find("option[value='"+$(select).val()+"']").remove();
                                $('#quitar').append($('<option>',{value:$(select).val()}).text($(select).text()));
                            });
                        }
                    });
                });
            </script>
        <?php endif; ?>
        <div class="col-md-12">
            <button id="submit" type="submit" class="btn btn-lg btn-primary btn-block" 
                style="max-width:200px; text-align:center;">Guardar</button>
        </div>
        <?php 
    }

    public function nueva() {
        $data['colaboradores'] = $this->user_model->getAll();
        $data['participantes']=array();
        $this->layout->title('Advanzer - Nueva Evaluación');
        $this->layout->view('evaluacion/nueva',$data);
    }

    public function registrar() {
        $datos=array(
            'anio'=>$this->input->post('anio'),
            'tipo'=>$this->input->post('tipo'),
            'nombre'=>$this->input->post('nombre'),
            'inicio'=>$this->input->post('inicio'),
            'fin'=>$this->input->post('fin'),
            'lider'=>$this->input->post('lider')
        );
        $this->db->trans_begin();
        $evaluacion=$this->evaluacion_model->create($datos);
        if($this->input->post('tipo') == 0){
            foreach ($this->input->post('agregar') as $colaborador) :
                $this->evaluacion_model->addEvaluadorToColaborador(array('evaluador'=>$this->input->post('lider'),
                    'evaluado'=>$colaborador,'evaluacion'=>$evaluacion));
            endforeach;
        }else{
            $this->evaluacion_model->asignar_evaluacion_anual($evaluacion);
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response['msg'] = "Ha habido un error. Intenta de nuevo";
        }else{
            $this->db->trans_commit();
            $response['msg']="ok";
        }
        echo json_encode($response);
    }

    private function genera_evaluacion($asignacion) {
        if($this->evaluacion_model->isAsignacionEmpty($asignacion))
            $this->evaluacion_model->fillAsignacion($asignacion);
    }

    private function valida_sesion() {
        if($this->session->userdata('id') == "")
            redirect('login');
    }
}