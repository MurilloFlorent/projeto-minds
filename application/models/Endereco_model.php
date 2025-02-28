<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Endereco_model extends CI_Model {

    public function get_enderecos_por_usuario($id) {
        return $this->db->get_where('enderecos', ['user_id' => $user_id])->result();
    }

    public function atualizar_endereco($id, $dados)
    {
        $this->db->where('id', $id);
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

        return $this->db->insert('enderecos', $data);
    }

    public function excluir($id)
    {
        return $this->db->delete('enderecos', ['id' => $id]);
    }

}
