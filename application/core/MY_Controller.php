<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function loadPartials($view = '', $data = '')
    {
        $this->load->view('_partials/headers', $data);
        $this->load->view($view, $data);
        $this->load->view('_partials/footer');
    }

}
