<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->model('Endereco_model');
        $this->load->library('session');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');  
        }
        $this->load->view('usuario/index.php');  
    }

    public function loginnow() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('senha', 'Senha', 'required');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email');
                $senha = $this->input->post('senha');

                $usuario = $this->Usuario_model->verificar_usuario($email, $senha);

                if ($usuario) {
                    if($usuario->status == 1){
                        $session_data = array(
                            'user_id' => $usuario->id,
                            'nome' => $usuario->nome,
                            'email' => $usuario->email,
                            'logged_in' => TRUE
                        );
                        $this->session->set_userdata($session_data);
                        redirect('dashboard');
                    }else {
                        $this->session->set_flashdata('erro', 'usuário inativo!');
                        redirect('/login');
                    }
                    
                } else {
                    $this->session->set_flashdata('erro', 'Email ou senha incorretos!');
                    redirect('/login');
                }
            } else {
                $this->load->view('usuario/login');
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->set_flashdata('mensagem', 'Você saiu com sucesso!');
        redirect('/login');
    }

    public function registrar() {
        $this->load->view('usuario/registrar.php');
    }

    public function registrarnow() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('cpf', 'CPF', 'required');
            $this->form_validation->set_rules('senha', 'Senha', 'required');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('sobrenome', 'Sobrenome', 'required');
            $this->form_validation->set_rules('estado_civil', 'Estado Civil', 'required');

            if($this->form_validation->run() === TRUE) {
                $usuario_dados = array(
                    'nome' => $this->input->post('nome'),
                    'email' => $this->input->post('email'),
                    'cpf' => $this->input->post('cpf'),
                    'telefone' => $this->input->post('telefone')  !== null ? $this->input->post('telefone') : "",
                    'sobrenome' => $this->input->post('sobrenome'),
                    'senha' => password_hash($this->input->post('senha'), PASSWORD_DEFAULT),
                    'estado_civil' => $this->input->post('estado_civil')
                );

                $usuario = $this->Usuario_model->salvar_usuario($usuario_dados);

                if ($usuario) {

                    $enderecos_array = [];
                    $ceps = $this->input->post('cep[]');
                    $enderecos = $this->input->post('endereco[]');
                    $numeros = $this->input->post('numero[]');
                    $complementos = $this->input->post('complemento[]');
                    $observacoes = $this->input->post('observacoes[]');

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

                    $this->session->set_flashdata('mensagem', 'Usuário criado com sucesso!');
                    redirect('/login');
                }
            }
        }
    }

    public function editar($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('/login');  
        }

        $data['usuario'] = $this->Usuario_model->get_usuario_com_enderecos($id);

        if (empty($data['usuario'])) {
            show_404();
        }

        $this->load->view('usuario/editar', $data);
    }

    public function ver($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('/login');  
        }

        $data['usuario'] = $this->Usuario_model->get_usuario_com_enderecos($id);

        if (empty($data['usuario'])) {
            show_404();
        }

        $this->load->view('usuario/ver', $data);
    }

    public function atualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_usuario = $this->input->post('id');

            $dados_usuario = array(
                'nome' => $this->input->post('nome'),
                'email' => $this->input->post('email'),
                'sobrenome' => $this->input->post('sobrenome'),
                'senha' => $this->input->post('senha'),
                'telefone' => $this->input->post('telefone'),
                'estado_civil' => $this->input->post('estado_civil'),
            );

            $this->Usuario_model->atualizar_usuario($id_usuario, $dados_usuario);

            $enderecos_id = $this->input->post('endereco_id[]'); 
            $ceps = $this->input->post('cep[]');
            $enderecos = $this->input->post('endereco[]');
            $numeros = $this->input->post('numero[]');
            $complementos = $this->input->post('complemento[]');
            $observacoes = $this->input->post('observacoes[]');

            foreach ($ceps as $index => $cep) {
                $endereco_dados = array(
                    'cep' => $cep,
                    'endereco' => $enderecos[$index],
                    'numero' => $numeros[$index],
                    'complemento' => isset($complementos[$index]) ? $complementos[$index] : null,
                    'observacoes' => isset($observacoes[$index]) ? $observacoes[$index] : null,
                    'user_id' => $id_usuario
                );

                if (!empty($enderecos_id[$index])) {
                    $this->Endereco_model->atualizar_endereco($enderecos_id[$index], $endereco_dados);
                } else {
                    $this->Endereco_model->salvar_endereco($endereco_dados);
                }
            }

            $this->session->set_flashdata('sucesso', 'Usuário atualizado com sucesso.');
            redirect('usuario/editar/' . $id_usuario);
        }
    }

    public function desativar($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('/login');  
        }
    
        if ($this->Usuario_model->desativar_usuario($id)) {
            $this->session->set_flashdata('sucesso', 'Usuário desativado com sucesso.');
        } else {
            $this->session->set_flashdata('erro', 'Erro ao desativar usuário.');
        }
    
        redirect('dashboard');
    }

    public function ativar($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('/login');  
        }
    
        if ($this->Usuario_model->ativar_usuario($id)) {
            $this->session->set_flashdata('sucesso', 'Usuário ativado com sucesso.');
        } else {
            $this->session->set_flashdata('erro', 'Erro ao ativar usuário.');
        }
    
        redirect('dashboard');
    }

    public function redefinir() {
        $id = $this->input->post('id');
        $senha_antiga = $this->input->post('senha_antiga');
        $nova_senha = $this->input->post('nova_senha');
        $confirmar_senha = $this->input->post('confirmar_senha');

        $usuario = $this->Usuario_model->get_user($id);

        if (!password_verify($senha_antiga, $usuario->senha)) {
            $this->session->set_flashdata('erro', 'Senha antiga incorreta.');
            redirect('usuario/editar/'.$id);
            return;
        }

        if ($nova_senha !== $confirmar_senha) {
            $this->session->set_flashdata('erro', 'As senhas não coincidem.');
            redirect('usuario/editar/'.$id);
            return;
        }

        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $this->Usuario_model->atualizar_senha($id, $senha_hash);

        $this->session->set_flashdata('sucesso', 'Senha redefinida com sucesso.');
        redirect('usuario/editar/'.$id);
    }

    public function excluirendereco() {
        if ($this->input->post('id_endereco') && $this->input->post('id_usuario')) {
            $endereco_id = $this->input->post('id_endereco');
            $id_usuario = $this->input->post('id_usuario');
    
            if ($this->Endereco_model->excluir($endereco_id)) {
                $this->session->set_flashdata('sucesso', 'Endereço removido com sucesso!');
            } else {
                $this->session->set_flashdata('erro', 'Erro ao remover endereço.');
            }
    
            redirect('usuario/editar/' . $id_usuario);
        } else {
            $this->session->set_flashdata('erro', 'Requisição inválida.');
            redirect('dashboard');
        }
    }
}
