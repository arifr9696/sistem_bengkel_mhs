<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('id')) {
            redirect('backend/dashboard');
            return;
        }

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            
            $data['titlePage'] = 'Login Bengkel';
            $this->loadPartials('login', $data);
        } else {
            
            $this->proses_login();
        }
    }

    public function proses_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user     = $this->login_model->getUser($username);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                
                $data = [
                    'id'       => $user['id'],
                    'nama'     => $user['nama'],
                    'username' => $user['username'],
                    'role'     => $user['role'],
                ];
                $this->session->set_userdata($data);
                redirect('backend/dashboard');
            } else {
                $this->session->set_flashdata('message', '<b>PASSWORD SALAH!</b>');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('message', '<b>USERNAME SALAH!</b>');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('id');
        redirect('login');
    }

}