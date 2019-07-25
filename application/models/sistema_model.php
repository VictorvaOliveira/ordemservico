<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sistema_Model extends CI_Model
{

	function __constructor()
	{
		parent::__contruct();
	}
	/**
	 * 
	 * RECUPERANDO TODAS AS ORDENS DE SERVIÇO
	 * 
	 */
	public function getAll()
	{

		return $this->db->get("od_ordem_de_servico")->result();
	}
	/**
	 * 
	 * LISTA DE OS BASEADO NO DIA ATUAL
	 * 
	 */
	public function lista_os()
	{
		date_default_timezone_set("America/Recife");		//DEFININDO FUSO HORÁRIO

		$dataAtual = date('Y-m-d');		//RECUPERANDO O DIA ATUAL PARA VERIFICAR NO WHERE

		$this->db->where('data_proximo_servico', $dataAtual);
		return $this->db->get('od_ordem_de_servico')->result();
	}

	/**
	 * 
	 * CADASTRO DE ORDEM DE SERVIÇO
	 * 
	 */
	public function addOs($id, $equipamento, $servico, $dateOpen, $dataPrevista, $periodo, $status)
	{
		$dados['id'] = $id;
		$dados['equipamento'] = $equipamento;
		$dados['servico'] = $servico;
		$dados['data_pedido'] = $dateOpen;
		$dados['data_proximo_servico'] = $dataPrevista;
		$dados['periodo'] = $periodo;
		$dados['status'] = $status;
		return $this->db->insert('od_ordem_de_servico', $dados);
	}
	/**
	 * 
	 * ATUALIZAR OS
	 * 
	 */
	public function atualizarOs($id, $status, $datarealizacao, $data_prox_servico, $staus_prox_servico)
	{
		$this->db->where('id', $id);
		$this->db->set('data_servico_update', $datarealizacao);
		$this->db->set('data_proximo_servico', $data_prox_servico);
		$this->db->set('status_proximo_servico', $staus_prox_servico);
		$this->db->set('status', $status);
		return $this->db->update('od_ordem_de_servico');
	}
	/**
	 * 
	 * ATUALIZAR OS 2
	 * 
	 */
	public function atualizarOs2($id, $equipamento, $servico, $dataOpen, $dataPrevista, $periodo){
		$this->db->where('id', $id);
		$this->db->set('equipamento', $equipamento);
		$this->db->set('servico', $servico);
		$this->db->set('data_pedido', $dataOpen);
		$this->db->set('data_proximo_servico', $dataPrevista);
		$this->db->set('periodo', $periodo);
		return $this->db->update('od_ordem_de_servico');
	}
	/**
	 * 
	 * RECUPERAR SOMENTE UMA OS
	 * 
	 */
	public function getOneOs($id)
	{
		$this->db->where("id", $id);
		return $this->db->get("od_ordem_de_servico")->result();
	}
	/**
	 * 
	 * GERANDO HISTÓRICO DE SERVIÇO
	 * 
	 */
	public function logOrdemServico($identificador, $equipamento, $servico, $datarealizacao)
	{
		$dados['id'] = $identificador;
		$dados['equipamento'] = $equipamento;
		$dados['servico'] = $servico;
		$dados['data_realizacao'] = $datarealizacao;
		return $this->db->insert("log_ordem_de_servico", $dados);
	}

	/**
	 * 
	 * RESGATANDO HISTÓRICO DE SERVIÇOS
	 * 
	 */
	public function historicoOrdemServico()
	{
		return $this->db->get('log_ordem_de_servico')->result();
	}
	/**
	 * 
	 * EXCLUINDO ORDEM DE SERVIÇO
	 * 
	 */
	public function remove($id)
	{
		return $this->db->delete("od_ordem_de_servico", array('id' => $id));
	}
}
