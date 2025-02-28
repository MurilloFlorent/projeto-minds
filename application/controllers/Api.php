<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->model('Endereco_model');
    }

    public function login()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['email']) || !isset($input['senha'])) {
            $this->output->set_status_header(400)->set_output(json_encode(['erro' => 'Email e senha são obrigatórios.']));
            return;
        }

        $usuario = $this->Usuario_model->verificar_usuario($input['email'], $input['senha']);

        if ($usuario) {
            echo json_encode(['sucesso' => true, 'usuario' => $usuario]);
        } else {
            $this->output->set_status_header(401)->set_output(json_encode(['erro' => 'Email ou senha incorretos.']));
        }
    }

    public function registrar()
{
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || empty($input['nome']) || empty($input['email']) || empty($input['cpf']) || empty($input['senha'])) {
        $this->output->set_status_header(400)->set_output(json_encode(['erro' => 'Todos os campos são obrigatórios.']));
        return;
    }

    $input['senha'] = password_hash($input['senha'], PASSWORD_DEFAULT);
    
    $usuario_id = $this->Usuario_model->salvar_usuario($input);

    if ($usuario_id) {
        $usuario = $this->Usuario_model->get_user($usuario_id);

        if ($usuario) {
            $enderecos_array = [];
            if (!empty($input['cep']) && is_array($input['cep'])) {
                $ceps = $input['cep'];
                $enderecos = $input['endereco'];
                $numeros = $input['numero'];
                $complementos = isset($input['complemento']) ? $input['complemento'] : [];
                $observacoes = isset($input['observacoes']) ? $input['observacoes'] : [];

                foreach ($ceps as $index => $cep) {
                    $enderecos_array[] = [
                        'cep' => $cep,
                        'endereco' => $enderecos[$index],
                        'numero' => $numeros[$index],
                        'complemento' => isset($complementos[$index]) ? $complementos[$index] : null, 
                        'observacoes' => isset($observacoes[$index]) ? $observacoes[$index] : null,
                        'user_id' => $usuario->id
                    ];
                }

                foreach ($enderecos_array as $endereco) {
                    $this->Endereco_model->salvar_endereco($endereco);
                }
            }

            echo json_encode(['sucesso' => true, 'id' => $usuario_id]);
        } else {
            $this->output->set_status_header(500)->set_output(json_encode(['erro' => 'Erro ao recuperar usuário após registro.']));
        }
    } else {
        $this->output->set_status_header(500)->set_output(json_encode(['erro' => 'Erro ao registrar usuário.']));
    }
}


    public function listar()
    {
        $usuarios = $this->Usuario_model->get_usuarios_com_enderecos();
        echo json_encode(['usuarios' => $usuarios]);
    }

    public function ver($id)
    {
        $usuario = $this->Usuario_model->get_usuario_com_enderecos($id);
        if ($usuario) {
            echo json_encode(['usuario' => $usuario]);
        } else {
            $this->output->set_status_header(404)->set_output(json_encode(['erro' => 'Usuário não encontrado.']));
        }
    }

    public function atualizar($id)
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if ($this->Usuario_model->atualizar_usuario($id, $input)) {
            echo json_encode(['sucesso' => true]);
        } else {
            $this->output->set_status_header(500)->set_output(json_encode(['erro' => 'Erro ao atualizar usuário.']));
        }
    }

    public function excluir($id)
    {
        if ($this->Usuario_model->excluir_usuario($id)) {
            echo json_encode(['sucesso' => true]);
        } else {
            $this->output->set_status_header(500)->set_output(json_encode(['erro' => 'Erro ao excluir usuário.']));
        }
    }
}
