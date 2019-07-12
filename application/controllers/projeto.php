<?php defined('BASEPATH') or exit('No direct script access allowed');

class Projeto extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		//Carregando model
		$this->load->model("sistema_model");
	}

	//Carregando ordens de serviço
	public function index($add = null)
	{
		$data['listaos'] = $this->sistema_model->lista_os();
		$data['add'] = $add;
		$this->load->view("lista", $data);
	}


	//Cadastro de ordens de serviço
	public function cadastro()
	{
		$this->load->view("add");
	}

	//Salvar ordem de serviço
	public function salvar()
	{
		$id        = $this->input->post('id');
		$equipamento = $this->input->post('equipamento');
		$servico = $this->input->post('describe');
		$dateOpen  = $this->input->post('dateOpen');
		$periodo = $this->input->post('periodo');
		$status    = "Em aberto";
		if ($this->sistema_model->addOs($id, $equipamento, $servico, $dateOpen, $periodo, $status)) {
			$data['listaos'] = $this->sistema_model->lista_os();
			$data["msg"] = "O cadastro efetuado com sucesso!";
			$this->session->set_flashdata(
				'cadastro-ok',
				'<div class="col-md-10">
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						Ordem de serviço adicionada !
					</div>
				</div>'
			);

			redirect("");
		}
	}

	//Função para atualizar ordem de serviço
	public function atualizar($id = null)
	{
		$ordemservico = $this->sistema_model->getOneOs($id);
		$data_recente = $this->sistema_model->data_recente($id);

		foreach ($ordemservico as $os) {
			$identificador = $os->id;
			$equipamento = $os->equipamento;
			$servico = $os->servico;
		}

		foreach ($data_recente as $dt) {
			$data = $dt->data_servico_update;
		}

		$periodo = $this->sistema_model->periodo_servico($id);
		foreach ($periodo as $pd) {
			$periodo_servico = $pd->periodo;
		}

		$dataupdate = new DateTime($data);

		if ($periodo_servico == 'd') {
			$dataupdate->add(new DateInterval('P1D'));
		} else if ($periodo_servico == 's') {
			$dataupdate->add(new DateInterval('P7D'));
		} else if ($periodo_servico == 'm') {
			$dataupdate->add(new DateInterval('P1M'));
		}

		$datarealizacao = date("Y-m-d");
		$data_prox_servico = $dataupdate->format("Y-m-d");

		$status = "Fechado";
		$staus_prox_servico = "Em aberto";
		if ($this->sistema_model->atualizarOs($id, $status, $datarealizacao, $data_prox_servico, $staus_prox_servico)) {
			$this->sistema_model->logOrdemServico($identificador, $equipamento, $servico, $datarealizacao);
			$this->session->set_flashdata(
				'atualizar-ok',
				'<div class="col-md-10">
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						Ordem de serviço atualizada !
					</div>
				</div>'
			);

			redirect("");
		}
	}

	public function historico_index(){

		$data['historicoOs'] = $this->sistema_model->historicoOrdemServico();
		$this->load->view("historico", $data);
	}
}
