<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

    }

    public function salvar_usuario($dados_usuario)
    {
        $dados_usuario['senha'] = password_hash($dados_usuario['senha'], PASSWORD_BCRYPT);

        $this->db->insert('usuarios', $dados_usuario);

        $usuario_id = $this->db->insert_id();

        $this->load->model('Log_model');
        $this->Log_model->registrar_log('usuarios', 'inserir', $dados_usuario, $usuario_id);

        return $this->get_user($usuario_id);
    }

    public function get_user($id)
    {
        $this->db->where('id', $id);
        $usuario = $this->db->get('usuarios')->row();

        return $usuario;
    }

    public function get_usuario_com_enderecos($id)
{
    $this->db->select('usuarios.*, enderecos.id as endereco_id, enderecos.cep, enderecos.endereco, enderecos.numero, enderecos.complemento, enderecos.observacoes');
    $this->db->from('usuarios');
    $this->db->join('enderecos', 'enderecos.user_id = usuarios.id', 'left');
    $this->db->where('usuarios.id', $id);

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        $result = $query->result_array();

        $usuario = [
            'id' => $result[0]['id'],
            'nome' => $result[0]['nome'],
            'email' => $result[0]['email'],
            'cpf' => $result[0]['cpf'],
            'sobrenome' => $result[0]['sobrenome'],
            'senha' => $result[0]['senha'],
            'telefone' => $result[0]['telefone'],
            'estado_civil' => $result[0]['estado_civil'],
            'enderecos' => []
        ];

        foreach ($result as $row) {
            if (!empty($row['endereco_id'])) { 
                $usuario['enderecos'][] = [
                    'id' => $row['endereco_id'],
                    'cep' => $row['cep'],
                    'endereco' => $row['endereco'],
                    'numero' => $row['numero'],
                    'complemento' => $row['complemento'],
                    'observacoes' => $row['observacoes']
                ];
            }
        }

        return $usuario;
    }

    return null;
}

public function get_usuarios_com_enderecos()
{
    $this->db->select('usuarios.*, enderecos.id as endereco_id, enderecos.cep, enderecos.endereco, enderecos.numero, enderecos.complemento, enderecos.observacoes');
    $this->db->from('usuarios');
    $this->db->join('enderecos', 'enderecos.user_id = usuarios.id', 'left');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        $results = $query->result_array();
        $usuarios = [];

        foreach ($results as $row) {
            $id_usuario = $row['id'];

            // Se o usuário ainda não foi adicionado, inicializa os dados
            if (!isset($usuarios[$id_usuario])) {
                $usuarios[$id_usuario] = [
                    'id' => $row['id'],
                    'nome' => $row['nome'],
                    'email' => $row['email'],
                    'cpf' => $row['cpf'],
                    'sobrenome' => $row['sobrenome'],
                    'senha' => $row['senha'],
                    'telefone' => $row['telefone'],
                    'estado_civil' => $row['estado_civil'],
                    'enderecos' => []
                ];
            }

            // Adiciona o endereço apenas se houver um endereço associado
            if (!empty($row['endereco_id'])) {
                $usuarios[$id_usuario]['enderecos'][] = [
                    'id' => $row['endereco_id'],
                    'cep' => $row['cep'],
                    'endereco' => $row['endereco'],
                    'numero' => $row['numero'],
                    'complemento' => $row['complemento'],
                    'observacoes' => $row['observacoes']
                ];
            }
        }

        // Retorna todos os usuários como uma lista
        return array_values($usuarios);
    }

    return [];
}


    public function get_usuarios() {
        $query = $this->db->get('usuarios');

        return $query->result();
    }

    public function atualizar_usuario($id, $dados)
    {
        // Atualiza os dados do usuário
        $this->db->where('id', $id);

        $this->load->model('Log_model');
        $this->Log_model->registrar_log('usuarios', 'atualizar', $dados,$this->session->userdata('user_id'));

        return $this->db->update('usuarios', $dados);

        
    }

    public function desativar_usuario($id) {
        $this->db->where('id', $id);

        $this->load->model('Log_model');
        $this->Log_model->registrar_log('usuarios', 'desativando_user', $id, $this->session->userdata('user_id'));

        return $this->db->update('usuarios', ['status' => 0]);

        
    }

    public function ativar_usuario($id) {
        $this->db->where('id', $id);

        $this->load->model('Log_model');
        $this->Log_model->registrar_log('usuarios', 'ativando_user', $id , $this->session->userdata('user_id'));

        return $this->db->update('usuarios', ['status' => 1]);

        
    }
    

    public function verificar_usuario($email, $senha)
    {
        $this->db->where('email', $email);
        $usuario = $this->db->get('usuarios')->row();

        if ($usuario && password_verify($senha, $usuario->senha)) {
            return $usuario;
        }

        return false;
    }

    public function atualizar_senha($id, $nova_senha)
    {
        $this->db->where('id', $id);

        $this->load->model('Log_model');
        $this->Log_model->registrar_log('usuarios', 'atualizando_senha', $id, $this->session->userdata('user_id'));

        return $this->db->update('usuarios', ['senha' => $nova_senha]);

        
    }
    
}
