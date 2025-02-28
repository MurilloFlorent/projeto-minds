<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Endereco_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

    }

    public function get_enderecos_por_usuario($id) {
        return $this->db->get_where('enderecos', ['user_id' => $user_id])->result();
    }

    public function atualizar_endereco($id, $dados)
    {
        $this->db->where('id', $id);

        $this->load->model('Log_model');
        $this->Log_model->registrar_log('enderecos', 'atualizando_endereco', $id, $this->session->userdata('user_id'));

        return $this->db->update('enderecos', $dados);

        
    }

    
    public function salvar_endereco($endereco)
    {
        $data = [
            'cep' => $endereco['cep'],
            'endereco' => $endereco['endereco'],
            'numero' => $endereco['numero'],
            'complemento' => $endereco['complemento'],
            'observacoes' => $endereco['observacoes'],
            'user_id' => $endereco['user_id']
        ];

        $this->load->model('Log_model');
        $this->Log_model->registrar_log('enderecos', 'inserindo', $id, $endereco['user_id']);

        return $this->db->insert('enderecos', $data);
    }

    public function excluir($id)
    {

        $this->load->model('Log_model');
        $this->Log_model->registrar_log('enderecos', 'deletando', $id, $this->session->userdata('user_id'));

        return $this->db->delete('enderecos', ['id' => $id]);
    }

}
