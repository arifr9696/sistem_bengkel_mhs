<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

        
        if (!$this->session->userdata('id')) {
            redirect('login');
        }
    }

    public function index()
    {
        
        $role = $this->session->userdata('role');

        if ($role === 'admin') {
            redirect('backend/dashboard/admin');
        } elseif ($role === 'mekanik') {
            redirect('backend/dashboard/mekanik');
        } elseif ($role === 'kasir') {
            redirect('backend/dashboard/kasir');
        } else {
            
            $this->session->unset_userdata('id');
            redirect('login');
        }
    }

    public function admin()
    {
        
        if ($this->session->userdata('role') !== 'admin') {
            redirect('backend/dashboard');
        }

        $data['title']    = 'Halaman Dashboard Admin';
        $data['nama']     = $this->session->userdata('nama');
        $data['username'] = $this->session->userdata('username');
        $data['role']     = strtoupper($this->session->userdata('role'));
        $data['titlePage'] = $data['title'];
        $this->loadPartials('backend/dashboard/admin', $data);
    }

    public function mekanik()
    {
        
        if ($this->session->userdata('role') !== 'mekanik') {
            redirect('backend/dashboard');
        }

        $data['title']    = 'Halaman Dashboard Mekanik';
        $data['nama']     = $this->session->userdata('nama');
        $data['username'] = $this->session->userdata('username');
        $data['role']     = strtoupper($this->session->userdata('role'));
        $data['titlePage'] = $data['title'];
        $this->loadPartials('backend/dashboard/mekanik', $data);
    }

    public function kasir()
    {
        
        if ($this->session->userdata('role') !== 'kasir') {
            redirect('backend/dashboard');
        }

        $data['title']    = 'Halaman Dashboard Kasir';
        $data['nama']     = $this->session->userdata('nama');
        $data['username'] = $this->session->userdata('username');
        $data['role']     = strtoupper($this->session->userdata('role'));
        $data['titlePage'] = $data['title'];
        
        $this->loadPartials('backend/dashboard/kasir', $data);
    }

}