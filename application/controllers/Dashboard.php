<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->library('session');
    }

    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('/login');  
        }

        $data['usuarios'] = $this->Usuario_model->get_usuarios();

        $this->load->view('dashboard/index.php', $data);
    }

}
