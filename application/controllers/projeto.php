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
		//Carregando biblioteca
		$this->load->library("form_validation");
		//Recebendo os valores do inputs
		$id = $this->input->post('id');
		$equipamento = $this->input->post('equipamento');
		$servico = $this->input->post('describe');
		$dateOpen  = $this->input->post('dateOpen');
		$periodo = $this->input->post('periodo');
		$status    = "Em aberto";
		//Criando regra de validação
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
		if ($this->form_validation->run() == FALSE) {
			$this->cadastro();
		} else {
			$this->sistema_model->addOs($id, $equipamento, $servico, $dateOpen, $dataPrevista, $periodo, $status);
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

		foreach ($ordemservico as $os) {
			$identificador = $os->id;
			$equipamento = $os->equipamento;
			$servico = $os->servico;
			$data = $os->data_proximo_servico;
			$periodo_servico = $os->periodo;
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

	//FUNÇÃO PARA RECUPERAR O HISTÓRICO DE SERVIÇOS 
	public function historico_index()
	{

		$data['historicoOs'] = $this->sistema_model->historicoOrdemServico();
		$this->load->view("historico", $data);
	}

	//FUNÇÃO PARA EXPORTAR DADOS
	public function exportarDados()
	{

		$filename = 'historico';
		$output = "";
		//Recuperando histórico de serviços
		$historico = $this->sistema_model->historicoOrdemServico();

		$output .= '<table border=2>
			<tr>
				<th>Identificador</th>
				<th>Equipamento</th>
				<th>Serviço</th>
				<th>Data Realização</th>
			</tr>';
		foreach ($historico as $ht) {
			$output .= '<tr>
			<td>' . $ht->id . '</td>
			<td>' . $ht->equipamento . '</td>
			<td>' . $ht->servico . '</td>
			<td>' . $ht->data_realizacao . '</td>
				</tr>';
		}
		$output .= '</table>';
		// Força o Download do Arquivo Gerado
		header("Content-Type: application/xsl");
		header("Content-Disposition: attachment; filename=$filename.xls");

		echo $output;
	}
}
