<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sistema_Model extends CI_Model
{

	function __constructor()
	{
		parent::__contruct();
	}

	public function lista_os()
	{
		//DEFININDO FUSO HORÁRIO

		date_default_timezone_set("America/Recife");
		//
		$dataAtual = date('Y-m-d');
		$this->db->where('data_proximo_servico', $dataAtual);
//		$this->db->where('data_proximo_servico', '2019-07-15');

		return $this->db->get('od_ordem_de_servico')->result();
	}

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

	public function atualizarOs($id, $status, $datarealizacao, $data_prox_servico, $staus_prox_servico)
	{
		$this->db->where('id', $id);
		$this->db->set('data_servico_update', $datarealizacao);
		$this->db->set('data_proximo_servico', $data_prox_servico);
		$this->db->set('status_proximo_servico', $staus_prox_servico);
		$this->db->set('status', $status);
		return $this->db->update('od_ordem_de_servico');
	}

	public function getOneOs($id){
		$this->db->where("id", $id);
		return $this->db->get("od_ordem_de_servico")->result();
	}

	public function logOrdemServico($identificador, $equipamento, $servico, $datarealizacao){
		$dados['id'] = $identificador;
		$dados['equipamento'] = $equipamento;
		$dados['servico'] = $servico;
		$dados['data_realizacao'] = $datarealizacao;
		return $this->db->insert("log_ordem_de_servico", $dados);
	}

	public function historicoOrdemServico(){
		return $this->db->get('log_ordem_de_servico')->result();
	}
}
