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
		//$this->db->where('data_servico_update', $dataAtual);
		return $this->db->get('od_ordem_de_servico')->result();
	}

	public function addOs($id, $equipamento, $servico, $dateOpen, $periodo, $status)
	{
		$dados['id'] = $id;
		$dados['equipamento'] = $equipamento;
		$dados['servico'] = $servico;
		$dados['data_pedido'] = $dateOpen;
		$dados['periodo'] = $periodo;
		$dados['status'] = $status;
		return $this->db->insert('od_ordem_de_servico', $dados);
	}

	public function atualizarOs($id, $status, $dataformatada)
	{
		$this->db->where('id', $id);
		$this->db->set('data_servico_update', $dataformatada);
		$this->db->set('status', $status);
		return $this->db->update('od_ordem_de_servico');
	}

	public function data_recente($id)
	{
		$query = $this->db->query("SELECT `data_servico_update` FROM `od_ordem_de_servico` where id = $id")->result();
		return $query;
	}

	public function periodo_servico($id)
	{
		$query = $this->db->query("SELECT `periodo` FROM `od_ordem_de_servico` where id = $id")->result();
		return $query;
	}
}
