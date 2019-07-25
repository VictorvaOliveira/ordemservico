<?php defined('BASEPATH') or exit('No direct script access allowed');

class Projeto extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model("sistema_model");	//Carregando model

	}

	/**
	 * 
	 * FUNÇÃO INDEX PARA CARREGAMENTO DE PÁGINA INICIAL
	 * TAL PÁGINA CONTARÁ COM APENAS AS ORDENS DE SERVIÇOS
	 * ABERTAS PARA AQUELE DETERMINADO DIA
	 * 
	 */
	public function index($add = null)
	{
		$data['listaos'] = $this->sistema_model->lista_os();
		$data['add'] = $add;
		$this->load->view("lista", $data);
	}

	/**
	 * 
	 * FUNÇÃO PARA CARREGAR VIEW DE CADASTRO DE ORDEM DE SERVIÇO
	 * 
	 */
	public function cadastro()
	{
		$this->load->view("add");
	}

	/**
	 * 
	 * FUNÇÃO PARA REALIZAR O SALVAMENTO DE ORDEM DE SERVIÇO
	 * 
	 */
	public function salvar($id = null, $equipamento = null, $servico = null, $dateOpen = null, $periodo = null)
	{
		//Carregando biblioteca

		$this->load->library("form_validation");		//BIBLIOTECA PARA VALIDAÇÃO DE FORMULÁRIO
		//Recebendo os valores do inputs
		$id = $this->input->post('id');
		$equipamento = $this->input->post('equipamento');
		$servico = $this->input->post('describe');
		$dateOpen  = $this->input->post('dateOpen');
		$periodo = $this->input->post('periodo');
		$status    = "Em aberto";
		//FIM DE RECEBIMENTO DE DADOS DO FÓRMULÁRIO

		//Criando regra de validação

		//REGRA: Verificar se um identificador é único
		$this->form_validation->set_rules(
			'id',
			'Código Ordem de serviço',
			'is_unique[od_ordem_de_servico.id]'
		);

		//Convertendo date do form em datetime
		$data = new DateTime($dateOpen);
		//Previsão do próximo serviço
		if ($periodo == 'd') {
			$data->add(new DateInterval('P1D'));
		} else if ($periodo == 's') {
			$data->add(new DateInterval('P7D'));
		} else if ($periodo == 'm') {
			$data->add(new DateInterval('P1M'));
		}
		//Data prevista
		$dataPrevista = $data->format("Y-m-d");
		//VALIDANDO O FORMULÁRIO MANDADO
		if ($this->form_validation->run() == FALSE) {
			$this->cadastro();
		} else {
			//REALIZANDO INSERÇÃO NO BANCO DE DADOS
			$this->sistema_model->addOs($id, $equipamento, $servico, $dateOpen, $dataPrevista, $periodo, $status);
			//ADICIONANDO RESPOSTAR AO USUÁRIO
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

	/**
	 * 
	 * função para atualizar ordem de serviço
	 * 
	 * */
	public function atualizar($id = null)
	{
		$ordemservico = $this->sistema_model->getOneOs($id);

		foreach ($ordemservico as $os) {
			$identificador = $os->id;
			$equipamento = $os->equipamento;
			$servico = $os->servico;
			$data = $os->data_proximo_servico;
			$periodo_servico = $os->periodo;
		}
		date_default_timezone_set("America/Recife");
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
	/**
	 * 
	 * ATUALIZAR TODA A ORDEM DE SERVICO
	 * 
	 */
	public function atualizar_os($id = null)
	{
		$id = $this->input->post('id');
		$equipamento = $this->input->post('equipamento');
		$servico = $this->input->post('describe');
		$dateOpen  = $this->input->post('dateOpen');
		$periodo = $this->input->post('periodo');

		//Convertendo date do form em datetime
		$data = new DateTime($dateOpen);
		//Previsão do próximo serviço
		if ($periodo == 'd') {
			$data->add(new DateInterval('P1D'));
		} else if ($periodo == 's') {
			$data->add(new DateInterval('P7D'));
		} else if ($periodo == 'm') {
			$data->add(new DateInterval('P1M'));
		}
		//Data prevista
		$dataPrevista = $data->format("Y-m-d");

		if ($this->sistema_model->atualizarOs2($id, $equipamento, $servico, $dateOpen, $dataPrevista, $periodo)) {
			$this->session->set_flashdata(
				'atualizar-ok',
				'<div class="col-md-10">
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						Ordem de serviço atualizada !
					</div>
				</div>'
			);
			redirect("projeto/all_ordem_servico");
		}
	}
	/**
	 * 
	 * FUNÇÃO PARA RECUPERAR O HISTÓRICO DE SERVIÇOS
	 * 
	 */
	public function historico_index()
	{

		$data['historicoOs'] = $this->sistema_model->historicoOrdemServico();
		$this->load->view("historico", $data);
	}
	/**
	 * 
	 * FUNÇÃO PARA RECUPERAR TODAS AS ORDENS DE SERVIÇO
	 * 
	 */
	public function all_ordem_servico()
	{
		$data['getAllOs'] = $this->sistema_model->getAll();
		$this->load->view("allos", $data);
	}

	/**
	 * 
	 * FUNÇÃO PARA CARREGAR A VIEW DE EDIÇÃO DA ORDEM DE SERVIÇO
	 * 
	 */
	public function editar($id = null)
	{
		$data['getone'] = $this->sistema_model->getOneOs($id);
		$this->load->view("editar", $data);
	}
	/**
	 * 
	 * FUNÇÃO PARA EXCLUIR UMA ORDEM DE SERVIÇO
	 * 
	 */
	public function excluir($id = null)
	{
		if ($this->sistema_model->remove($id)) {
			$this->session->set_flashdata(
				'exclusao-ok',
				'<div class="col-md-10">
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Ordem de serviço excluída !
				</div>
			</div>'
			);

			$this->all_ordem_servico();
		}
	}
}
