<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Error extends CI_Controller
{
    public function index()
    {
        $this->load->view('blocked');
    }
}
